<?php
class AccountController extends Controller {

    // Bắt buộc phải đăng nhập mới được vào
    public function __construct() {
        if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    // 1. Hiển thị giao diện Quản lý tài khoản
    public function index() {
        // Lấy tab hiện tại từ URL (mặc định là 'info')
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'info';
        $ma_kh = $_SESSION['user_info']['ma_kh'];

        // Lấy thông tin user
        $userModel = $this->model('User');
        $user_info = $userModel->get_user_byid($ma_kh);
        
        $data = [
            'title' => 'Quản lý tài khoản',
            'tab' => $tab,
            'user_info' => $user_info[0] ?? $_SESSION['user_info']
        ];

        // Nếu ở tab xem đơn hàng, gọi thêm Model Order
        if ($tab == 'xem_donhang') {
            $orderModel = $this->model('Order');
            $data['list_order'] = $orderModel->getAll_Byid_kh($ma_kh);
        }

        // Nếu ở tab xem chi tiết đơn, gọi Order và Order_item
        if ($tab == 'xem_chitiet' && isset($_GET['ma_dh'])) {
            $ma_dh = (int)$_GET['ma_dh'];
            $orderModel = $this->model('Order');
            $orderItemModel = $this->model('Order_item');

            $data['order_info'] = $orderModel->getByid($ma_dh);
            $data['items'] = $orderItemModel->getAll_orderitem_info_byid($ma_dh);
            $data['ma_dh'] = $ma_dh;
        }

        $this->view('user/account/index', $data);
    }

    // 2. Xử lý Cập nhật thông tin
    public function updateInfo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_kh = trim($_POST['ten_kh'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');

            if (!empty($ten_kh) && !empty($email) && !empty($sdt) && !empty($dia_chi)) {
                $userModel = $this->model('User');
                $ma_kh = $_SESSION['user_info']['ma_kh'];
                
                // Cập nhật Database
                $userModel->update_info($ten_kh, $email, $sdt, $dia_chi, $ma_kh);
                
                // Cập nhật lại Session
                $_SESSION['user_info']['ten_kh'] = $ten_kh;
                $_SESSION['user_info']['email'] = $email;
                $_SESSION['user_info']['sdt'] = $sdt;
                $_SESSION['user_info']['dia_chi'] = $dia_chi;

                $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Đã cập nhật thông tin.', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi!', 'text' => 'Vui lòng điền đủ thông tin.', 'icon' => 'error'];
            }
            header('Location: /tai-khoan?tab=change_info');
            exit;
        }
    }

    // 3. Xử lý Đổi mật khẩu
    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pass = $_POST['pass_new'] ?? '';
            $passconfirm = $_POST['pass_confirm'] ?? '';

            if ($pass === $passconfirm && !empty($pass)) {
                $userModel = $this->model('User');
                $ma_kh = $_SESSION['user_info']['ma_kh'];
                
                $userModel->update_password($pass, $ma_kh);
                
                $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Đã đổi mật khẩu an toàn.', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi!', 'text' => 'Mật khẩu xác nhận không khớp.', 'icon' => 'error'];
            }
            header('Location: /tai-khoan?tab=change_pass');
            exit;
        }
    }

    // 4. Xử lý Hủy đơn hàng
    public function cancelOrder($ma_dh) {
        $orderModel = $this->model('Order');
        $orderItemModel = $this->model('Order_item');
        $dacdiem_sp = $this->model('Dacdiem_sp');
        $ma_kh = $_SESSION['user_info']['ma_kh'];

        // Kiểm tra xem đơn hàng có thuộc về user này không để chống hack
        $orderInfo = $orderModel->getByid($ma_dh);
        
        if (!empty($orderInfo) && $orderInfo[0]['ma_kh'] == $ma_kh) {
            $trangthai = $orderInfo[0]['trangthai'];
            
            // Chỉ cho phép hủy khi đang chờ xử lý
            if ($trangthai != 'huy' && $trangthai != 'dagiao' && $trangthai != 'daxacnhan') {
                $data_item = $orderItemModel->getAll_orderitem_info_byid($ma_dh);
                
                // Hoàn lại tồn kho (Đã sửa lại thành chat_lieu và phien_ban)
                foreach ($data_item as $v) {
                    $dacdiem_sp->update_tonkho($v['ma_sp'], $v['chat_lieu'], $v['phien_ban'], $v['soluong'], 'tang');
                }
                
                // Cập nhật trạng thái Hủy
                $orderModel->update_order($ma_dh, 'huy');
                
                $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Đã hủy đơn hàng.', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Từ chối!', 'text' => 'Đơn hàng này không thể hủy.', 'icon' => 'error'];
            }
        }
        
        header('Location: /tai-khoan?tab=xem_donhang');
        exit;
    }
}
?>