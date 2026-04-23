<?php
class AdminCategoryController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

   
    public function index() {
        $catModel = $this->model('Category');
        $list_dm = $catModel->getAll_dm();
        
        $data = [
            'title' => 'Quản lý Danh mục',
            'list_dm' => $list_dm
        ];
        
        $this->view('admin/category/category', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['ten_danhmuc'])) {
            $ten_danhmuc = trim($_POST['ten_danhmuc']);
            
            $catModel = $this->model('Category');
            $catModel->add_dm($ten_danhmuc); 
            
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã thêm danh mục!'];
        }
        header('Location: /admin/danh-muc');
        exit;
    }

  
    public function edit($id) {
        $catModel = $this->model('Category');
        
        $data = [
            'title' => 'Cập nhật Danh mục',
            'list_dm' => $catModel->getAll_dm(), 
            'dm_can_sua' => $catModel->getByid_dm($id)[0] ?? null 
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

    
    public function delete($id) {
        $catModel = $this->model('Category');
        $catModel->del_dm($id);
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Đã xóa', 'text' => 'Danh mục đã bị xóa.'];
        header('Location: /admin/danh-muc');
        exit;
    }
}
?>