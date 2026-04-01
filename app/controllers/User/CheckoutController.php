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

    // Hàm tạo link thanh toán MoMo
    public function momoPayment() {
        if (!isset($_SESSION['user_order']) || $_SESSION['user_order'][5] != 'momo') {
            header('Location: /gio-hang');
            exit;
        }

        $tongtien = $_SESSION['user_order'][1];
        $ma_kh = $_SESSION['user_order'][0];

        // 1. THÔNG SỐ KẾT NỐI MÔI TRƯỜNG TEST CỦA MOMO
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMONPMB20210629";
$accessKey = "Q2XhhSdgpKUlQ4Ky";
$secretKey = "k6B53GQKSjktZGJBK2MyrDa7w9S6RyCf";

        // 2. THÔNG TIN ĐƠN HÀNG
        $orderInfo = "Thanh_toan_don_hang";
        $amount = (string)$tongtien;
        $orderId = time() . "_KH" . $ma_kh; // Tạo mã đơn hàng ngẫu nhiên không trùng lặp
        $redirectUrl = "https://huynhngocquan.id.vn/xac-nhan-momo"; // Domain thật của bạn
        $ipnUrl = "https://huynhngocquan.id.vn/xac-nhan-momo"; 
        $redirectUrl = trim($redirectUrl);
$ipnUrl = trim($ipnUrl);
        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = "";

        // 3. TẠO CHỮ KÝ BẢO MẬT (SIGNATURE) THEO CHUẨN MOMO
        
        //$rawHash = "accessKey=".$accessKey."&amount=".$amount."&extraData=".$extraData."&ipnUrl=".$ipnUrl."&orderId=".$orderId."&orderInfo=".$orderInfo."&partnerCode=".$partnerCode."&redirectUrl=".$redirectUrl."&requestId=".$requestId."&requestType=".$requestType;
        $rawHash = sprintf(
    "accessKey=%s&amount=%s&extraData=%s&ipnUrl=%s&orderId=%s&orderInfo=%s&partnerCode=%s&redirectUrl=%s&requestId=%s&requestType=%s",
    $accessKey,
    $amount,
    $extraData,
    $ipnUrl,
    $orderId,
    $orderInfo,
    $partnerCode,
    $redirectUrl,
    $requestId,
    $requestType
);
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // 4. ĐÓNG GÓI DỮ LIỆU
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Chapter One - The Beginning",
            "storeId" => "MOMONPMB20210629_1",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        // 5. GỬI SANG MOMO THÔNG QUA CURL
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Vượt rào SSL trên máy ảo
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $result = curl_exec($ch);
        curl_close($ch);

        $jsonResult = json_decode($result, true);
        

        // 6. KIỂM TRA PHẢN HỒI, NẾU ĐÚNG THÌ CHUYỂN TRANG
        if (isset($jsonResult['payUrl'])) {
            header('Location: ' . $jsonResult['payUrl']);
            exit;
        } else {
            $_SESSION['flash_alert'] = ['title' => 'Lỗi kết nối', 'text' => 'Không thể tải cổng thanh toán MoMo lúc này.', 'icon' => 'error'];
            header('Location: /gio-hang');
            exit;
        }
    }

    // Hàm xử lý kết quả MoMo trả về
    public function momoReturn() {
        // Lấy mã kết quả từ URL do MoMo ném về
        $resultCode = isset($_GET['resultCode']) ? $_GET['resultCode'] : null;

        if ($resultCode === '0' && isset($_SESSION['user_order'])) {
            // ==========================================
            // GIAO DỊCH THÀNH CÔNG -> LƯU VÀO DATABASE
            // ==========================================
            $ma_kh = $_SESSION['user_order'][0];
            
            $order = $this->model('Order');
            $order_item = $this->model('Order_item');
            $cart = $this->model('Cart');
            $dacdiem_sp = $this->model('Dacdiem_sp');

            // 1. Lấy giỏ hàng
            $list_cart = $cart->getAllcart_info_byid($ma_kh);

            // 2. Thêm đơn hàng (trạng thái: choxuly, pttt: momo)
            $trangthai = 'choxuly'; 
            $ma_dh = $order->add_order($_SESSION['user_order'][0], $_SESSION['user_order'][1], $_SESSION['user_order'][2], $_SESSION['user_order'][3], $trangthai, 'momo', $_SESSION['user_order'][6], $_SESSION['user_order'][7], $_SESSION['user_order'][8], $_SESSION['user_order'][9], $_SESSION['user_order'][10]);

            // 3. Thêm chi tiết và trừ tồn kho
            foreach ($list_cart as $item) {
                $order_item->add_order_item($item['ma_sp'], $ma_dh, $item['size'], $item['soluong'], $item['giasp'], $item['loai_mau']);
                $dacdiem_sp->update_tonkho($item['ma_sp'], $item['size'], $item['loai_mau'], $item['soluong'], 'giam');
            }

            // 4. Dọn dẹp giỏ hàng
            $cart->del_byid_kh($ma_kh);
            $_SESSION['user_cart']['count'] = 0;
            unset($_SESSION['user_order']); // Xóa session tạm

            $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Thanh toán MoMo thành công.', 'icon' => 'success'];
            header("Location: /tai-khoan"); 
            exit;

        } else {
            // ==========================================
            // GIAO DỊCH THẤT BẠI HOẶC BỊ HỦY
            // ==========================================
            $_SESSION['flash_alert'] = ['title' => 'Thất bại', 'text' => 'Giao dịch MoMo bị hủy hoặc không thành công.', 'icon' => 'error'];
            header("Location: /gio-hang");
            exit;
        }
    }
}
?>