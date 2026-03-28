<?php
class AdminCategoryController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    // Hiển thị danh sách danh mục
    public function index() {
        $catModel = $this->model('Category');
        $list_dm = $catModel->getAll_dm();
        
        $data = [
            'title' => 'Quản lý Danh mục',
            'list_dm' => $list_dm
        ];
        // Trỏ tới file view: app/views/admin/category/category.php
        $this->view('admin/category/category', $data);
    }

    // Xử lý Thêm danh mục
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['ten_danhmuc'])) {
            $ten_danhmuc = trim($_POST['ten_danhmuc']);
            
            $catModel = $this->model('Category');
            $catModel->add_dm($ten_danhmuc); // Hàm add_dm trong Model Category.class.php
            
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã thêm danh mục!'];
        }
        header('Location: /admin/danh-muc');
        exit;
    }

    // Xử lý Cập nhật danh mục
    public function edit($id) {
        $catModel = $this->model('Category');
        
        $data = [
            'title' => 'Cập nhật Danh mục',
            'list_dm' => $catModel->getAll_dm(), // Vẫn phải lấy list để in ra bảng
            'dm_can_sua' => $catModel->getByid_dm($id)[0] ?? null // Lấy thông tin danh mục muốn sửa
        ];
        
        $this->view('admin/category/category', $data);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['ten_danhmuc'])) {
            $ten_danhmuc = trim($_POST['ten_danhmuc']);
            
            $catModel = $this->model('Category');
            $catModel->update_dm($id, $ten_danhmuc); 
            
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã cập nhật danh mục!'];
        }
        header('Location: /admin/danh-muc');
        exit;
    }

    // Xử lý Xóa danh mục
    public function delete($id) {
        $catModel = $this->model('Category');
        $catModel->del_dm($id);
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Đã xóa', 'text' => 'Danh mục đã bị xóa.'];
        header('Location: /admin/danh-muc');
        exit;
    }
}
?>