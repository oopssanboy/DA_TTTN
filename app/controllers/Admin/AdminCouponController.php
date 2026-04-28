<?php
class AdminCouponController extends Controller {

    public function __construct() {
        // Bắt buộc phải là Admin mới được vào
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    // Hiển thị danh sách Mã giảm giá
    public function index() {
        $couponModel = $this->model('Coupon');
        $list_coupons = $couponModel->getAllCoupons();

        $data = [
            'title' => 'Quản lý Mã giảm giá - Admin',
            'list_coupons' => $list_coupons
        ];
        // Bạn sẽ cần tạo View admin/coupon/index.php
        $this->view('admin/coupon/index', $data);
    }
    public function create() {
        $data = [
            'title' => 'Thêm mã khuyến mãi mới'
        ];
        $this->view('admin/coupon/add_edit', $data);
    }
    // Lưu mã giảm giá mới vào Database (Xử lý Form submit)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = strtoupper(trim($_POST['code'])); // Tự động viết hoa mã
            $type = $_POST['type'];
            $value = (int)$_POST['value'];
            $min_order_value = (int)$_POST['min_order_value'];
            $max_discount = (int)$_POST['max_discount'];
            $usage_limit = (int)$_POST['usage_limit'];
            $usage_per_user = (int)$_POST['usage_per_user'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $status = isset($_POST['status']) ? 1 : 0;

            $couponModel = $this->model('Coupon');
            
            // Có thể thêm hàm check trùng mã code ở đây nếu cẩn thận hơn
            $result = $couponModel->addCoupon($code, $type, $value, $min_order_value, $max_discount, $usage_limit, $usage_per_user, $start_date, $end_date, $status);

            if ($result) {
                $_SESSION['flash_alert'] = ['title' => 'Thành công', 'text' => 'Đã thêm mã giảm giá mới!', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => 'Không thể thêm mã (Có thể mã code bị trùng).', 'icon' => 'error'];
            }
            
            header('Location: /admin/khuyen-mai');
            exit;
        }
    }
    public function edit($id) {
        $couponModel = $this->model('Coupon');
        $cp = $couponModel->getCouponById($id);

        if (!$cp) {
            $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Mã không tồn tại!'];
            header('Location: /admin/khuyen-mai');
            exit;
        }

        $data = [
            'title' => 'Cập nhật mã: ' . $cp['code'],
            'cp' => $cp // Truyền dữ liệu mã cũ sang View
        ];
        $this->view('admin/coupon/add_edit', $data);
    }

    // 5. Xử lý cập nhật dữ liệu sau khi sửa
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = strtoupper(trim($_POST['code']));
            $type = $_POST['type'];
            $value = (int)$_POST['value'];
            $min_order_value = (int)$_POST['min_order_value'];
            $max_discount = (int)$_POST['max_discount'];
            $usage_limit = (int)$_POST['usage_limit'];
            $usage_per_user = (int)$_POST['usage_per_user'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $status = (int)$_POST['status'];

            $couponModel = $this->model('Coupon');
            $result = $couponModel->updateCoupon($id, $code, $type, $value, $min_order_value, $max_discount, $usage_limit, $usage_per_user, $start_date, $end_date, $status);

            if ($result) {
                $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã cập nhật thông tin mã!'];
            } else {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Không có thay đổi nào được thực hiện.'];
            }
            header('Location: /admin/khuyen-mai');
            exit;
        }
    }
    // Xóa mã
    public function delete($id) {
        $couponModel = $this->model('Coupon');
        $couponModel->deleteCoupon($id);
        $_SESSION['flash_alert'] = ['title' => 'Thành công', 'text' => 'Đã xóa mã giảm giá!', 'icon' => 'success'];
        header('Location: /admin/khuyen-mai');
        exit;
    }
}
?>