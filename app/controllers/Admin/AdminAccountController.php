<?php
class AdminAccountController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    // 1. Hiển thị thông tin Admin
    public function index() {
        // Có thể lấy lại thông tin mới nhất từ DB để đảm bảo độ chính xác
        $userModel = $this->model('User');
        $ma_kh = $_SESSION['user_info']['ma_kh'];
        $admin_info = $userModel->get_user_byid($ma_kh);

        $data = [
            'title' => 'Thông tin cá nhân',
            'admin_info' => $admin_info[0] ?? $_SESSION['user_info']
        ];
        
        // Trỏ tới file view thông tin tài khoản admin
        $this->view('admin/account/account_info', $data);
    }

    // 2. Cập nhật thông tin Admin
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_kh = $_POST['ten_kh'] ?? '';
            $email = $_POST['email'] ?? '';
            $sdt = $_POST['sdt'] ?? '';
            $dia_chi = $_POST['dia_chi'] ?? '';
            
            $ma_kh = $_SESSION['user_info']['ma_kh'];
            
            $userModel = $this->model('User');
            $userModel->update_info($ten_kh, $email, $sdt, $dia_chi, $ma_kh);
            
            // Cập nhật lại session
            $_SESSION['user_info']['ten_kh'] = $ten_kh;
            $_SESSION['user_info']['email'] = $email;
            $_SESSION['user_info']['sdt'] = $sdt;
            $_SESSION['user_info']['dia_chi'] = $dia_chi;

            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Cập nhật thông tin Quản trị viên thành công!'];
            header('Location: /admin/thong-tin');
            exit;
        }
    }
}
?>