<?php
class AdminCustomerController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    // 1. Hiển thị danh sách khách hàng
    public function index() {
        $userModel = $this->model('User');
        // Lấy toàn bộ danh sách khách hàng (role = 0)
        $list_customers = $userModel->getAll_User(); 
        
        $data = [
            'title' => 'Quản lý Khách hàng',
            'list_customers' => $list_customers
        ];
        
        $this->view('admin/customers/list_customers', $data);
    }

    // 2. Khóa tài khoản
    public function lock($id) {
        $userModel = $this->model('User');
        $userModel->update_trangthai($id, 'dakhoa'); 
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Tài khoản đã bị khóa!'];
        header('Location: /admin/khach-hang');
        exit;
    }

    // 3. Mở khóa tài khoản
    public function unlock($id) {
        $userModel = $this->model('User');
        $userModel->update_trangthai($id, 'hoatdong');
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã mở khóa tài khoản!'];
        header('Location: /admin/khach-hang');
        exit;
    }
}
?>