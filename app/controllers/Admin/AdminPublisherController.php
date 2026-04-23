<?php
class AdminPublisherController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

   
    public function index() {
        $nxbModel = $this->model('NXB');
        $list_nxb = $nxbModel->getAll();
        
        $data = [
            'title' => 'Quản lý Nhà xuất bản',
            'list_nxb' => $list_nxb
        ];
      
        $this->view('admin/nha_xuat_ban/nha_xuat_ban', $data);
    }

  
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['ten_nxb'])) {
            $ten_nxb = trim($_POST['ten_nxb']);
            
            $nxbModel = $this->model('NXB');
            $nxbModel->add_nxb($ten_nxb); 
            
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã thêm nhà xuất bản mới!'];
        }
        header('Location: /admin/nha-xuat-ban');
        exit;
    }


    public function edit($id) {
        $nxbModel = $this->model('NXB');
        $data = [
            'title' => 'Cập nhật Nhà Xuất Bản',
            'list_nxb' => $nxbModel->getAll(), 
            'nxb_can_sua' => $nxbModel->getByid_nxb($id)[0] ?? null 
        ];
        
        $this->view('admin/nha_xuat_ban/nha_xuat_ban', $data);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['ten_nxb'])) {
            $ten_nxb = trim($_POST['ten_nxb']);
            
            $nxbModel = $this->model('NXB');
            $nxbModel->update_nxb($id, $ten_nxb);
            
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã cập nhật nhà xuất bản!'];
        }
        header('Location: /admin/nha-xuat-ban');
        exit;
    }

    public function delete($id) {
        $nxbModel = $this->model('NXB');
        $nxbModel->del_nxb($id);
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Đã xóa', 'text' => 'Nhà xuất bản đã bị xóa.'];
        header('Location: /admin/nha-xuat-ban');
        exit;
    }
}
?>