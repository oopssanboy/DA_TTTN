<?php
class AdminCustomerController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    public function index() {
        $userModel = $this->model('User');
       
        $list_customers = $userModel->getAll_User(); 
        
        $data = [
            'title' => 'Quản lý Khách hàng',
            'list_customers' => $list_customers
        ];
        
        $this->view('admin/customers/list_customers', $data);
    }


    public function lock($id) {
        $userModel = $this->model('User');
        $userModel->update_trangthai($id, 'dakhoa'); 
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Tài khoản đã bị khóa!'];
        header('Location: /admin/khach-hang');
        exit;
    }


    public function unlock($id) {
        $userModel = $this->model('User');
        $userModel->update_trangthai($id, 'hoatdong');
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã mở khóa tài khoản!'];
        header('Location: /admin/khach-hang');
        exit;
    }
    public function history($id) {
        $userModel = $this->model('User');
        $orderModel = $this->model('Order');
        $customer = $userModel->get_user_byid($id); 
        
      
        if (!$customer) {
            $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => 'Không tìm thấy khách hàng!', 'icon' => 'error'];
            header('Location: /admin/khach-hang');
            exit;
        }

        
        $orders = $orderModel->getAll_Byid_kh($id);

        $data = [
            'title' => 'Lịch sử mua hàng - Admin',
            'customer' => $customer[0] ?? $customer, 
            'orders' => $orders
        ];

        $this->view('admin/customers/history', $data);
    }
}
?>