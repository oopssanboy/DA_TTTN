<?php
class DashboardController extends Controller {

    public function __construct() {
        // Kiểm tra quyền truy cập: Bắt buộc phải là Admin
        if (!isset($_SESSION['admin_login'])) {
            $_SESSION['flash_alert'] = ['icon' => 'warning', 'title' => 'Từ chối truy cập', 'text' => 'Bạn không có quyền vào trang Quản trị!'];
            header('Location: /dang-nhap');
            exit;
        }
    }

    public function index() {
        // Ở đây sau này bạn có thể gọi các Model (Order, User, Sach) 
        // để đếm tổng số đơn hàng, doanh thu... và truyền ra View thống kê
        
        $data = [
            'title' => 'Thống kê- Chapter One'
        ];

        // Gọi ra giao diện trang chủ Admin
        $this->view('admin/dashboard/index', $data);
    }
}
?>