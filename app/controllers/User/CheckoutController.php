<?php
class CheckoutController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    // 1. Hiển thị trang QR thanh toán
    public function index() {
        // Kiểm tra xem có đơn hàng đang chờ thanh toán không
        if (!isset($_SESSION['user_order']) || $_SESSION['user_order'][5] != 'bank') {
            header('Location: /gio-hang');
            exit;
        }

        $data = [
            'title' => 'Thanh toán chuyển khoản - Chapter One',
            // Truyền thêm dữ liệu đơn hàng nếu bạn muốn hiển thị tổng tiền ở trang QR
            'tongtien' => $_SESSION['user_order'][1] 
        ];

        $this->view('user/checkout/index', $data); // Trỏ tới file view QR của bạn
    }

    // 2. Xử lý khi nhấn nút "Xác nhận đã thanh toán"
    public function confirmPayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_order'])) {
            
            $ma_kh = $_SESSION['user_order'][0];
            
            $order = $this->model('Order');
            $order_item = $this->model('Order_item');
            $cart = $this->model('Cart');
            $dacdiem_sp = $this->model('Dacdiem_sp');

            // Lấy lại giỏ hàng để đưa vào chi tiết đơn
            $list_cart = $cart->getAllcart_info_byid($ma_kh);

            // Lưu vào bảng orders
            // Lưu ý: Có thể bạn muốn đổi trạng thái thành 'choduyet' hoặc tương tự để admin biết là chuyển khoản
            $trangthai = 'choxuly'; 
            
            $ma_dh = $order->add_order($_SESSION['user_order'][0], $_SESSION['user_order'][1], $_SESSION['user_order'][2], $_SESSION['user_order'][3], $trangthai, $_SESSION['user_order'][5], $_SESSION['user_order'][6], $_SESSION['user_order'][7], $_SESSION['user_order'][8], $_SESSION['user_order'][9], $_SESSION['user_order'][10]);

            // Lưu vào bảng order_items và trừ tồn kho
            foreach ($list_cart as $item) {
                $order_item->add_order_item($item['ma_sp'], $ma_dh, $item['chat_lieu'], $item['soluong'], $item['giasp'], $item['phien_ban']);
                $dacdiem_sp->update_tonkho($item['ma_sp'], $item['chat_lieu'], $item['phien_ban'], $item['soluong'], 'giam');
            }

            // Xóa giỏ hàng và session tạm
            $cart->del_byid_kh($ma_kh);
            $_SESSION['user_cart']['count'] = 0;
            unset($_SESSION['user_order']);

            $_SESSION['flash_alert'] = [
                'title' => 'Thành công!', 
                'text' => 'Đã ghi nhận yêu cầu thanh toán. Chúng tôi sẽ xử lý sớm.', 
                'icon' => 'success'
            ];
            
            // Chuyển hướng về trang lịch sử đơn hàng
            header("Location: /gio-hang");
            exit;
        } else {
             header("Location: /gio-hang");
             exit;
        }
    }
}
?>