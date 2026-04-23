<?php
class AdminOrderController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }


    public function index() {
        $orderModel = $this->model('Order');
        $list_orders = $orderModel->getAll(); 
        
        $data = [
            'title' => 'Quản lý Đơn hàng',
            'list_orders' => $list_orders
        ];
        $this->view('admin/orders/list_orders', $data);
    }


    public function detail($ma_dh) {
        $orderModel = $this->model('Order');
        $orderItemModel = $this->model('Order_item');

        $order_info = $orderModel->getByid($ma_dh);
        
        if (empty($order_info)) {
            $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Đơn hàng không tồn tại!'];
            header('Location: /admin/don-hang');
            exit;
        }

        $data = [
            'title' => 'Chi tiết đơn hàng #' . $ma_dh,
            'od' => $order_info[0],
            'items' => $orderItemModel->getAll_orderitem_info_byid($ma_dh)
        ];
        $this->view('admin/orders/orders_item', $data);
    }

    public function updateStatus($ma_dh) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trangthai'])) {
            $this->changeOrderStatus($ma_dh, $_POST['trangthai']);
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Cập nhật trạng thái thành công!'];
        }
        header('Location: /admin/don-hang/chi-tiet/' . $ma_dh);
        exit;
    }

    public function confirm($ma_dh) {
        $this->changeOrderStatus($ma_dh, 'daxacnhan');
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã xác nhận đơn hàng!'];
        header('Location: /admin/don-hang/chi-tiet/' . $ma_dh);
        exit;
    }

    public function cancel($ma_dh) {
        $this->changeOrderStatus($ma_dh, 'huy');
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Đã hủy', 'text' => 'Đơn hàng đã được hủy và hoàn lại tồn kho!'];
        
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;
    }

    private function changeOrderStatus($ma_dh, $trangthai_moi) {
        $orderModel = $this->model('Order');
        $order_info = $orderModel->getByid($ma_dh);
        
        if(!empty($order_info)) {
            $trangthai_cu = $order_info[0]['trangthai'];
            
            if ($trangthai_cu != 'huy' && $trangthai_moi == 'huy') {
                $orderItemModel = $this->model('Order_item');
                $dacdiem_sp = $this->model('Dacdiem_sp');
                $items = $orderItemModel->getAll_orderitem_info_byid($ma_dh);
                
                foreach ($items as $v) {
                    $dacdiem_sp->update_tonkho($v['ma_sp'], $v['chat_lieu'], $v['phien_ban'], $v['soluong'], 'tang');
                }
            }
        
            $orderModel->update_order($ma_dh, $trangthai_moi);
        }
    }
}
?>