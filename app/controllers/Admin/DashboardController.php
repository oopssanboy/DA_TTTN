<?php
class DashboardController extends Controller {
    
    public function __construct() {
  
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    public function index() {
    
        $statModel = $this->model('Thongke');

        $overview = $statModel->getOverview();
        $recent_orders = $statModel->getRecentOrders(10);
        $data = [
            'title' => 'Tổng Quan - Admin Chapter One',
            'overview' => $overview,
            'recent_orders' => $recent_orders
        ];

        $this->view('admin/dashboard/index', $data);
    }
}
?>