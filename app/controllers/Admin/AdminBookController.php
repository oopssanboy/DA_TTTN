<?php
class AdminBookController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    
    public function index() {
        $productModel = $this->model('Sach');
        $data = [
            'title' => 'Quản lý Sản phẩm',
            'list_product' => $productModel->getAll()
        ];
        $this->view('admin/products/list_product', $data);
    }


    public function create() {
        $categoryModel = $this->model('Category');
        $nxbModel = $this->model('NXB');

        $data = [
            'title' => 'Thêm Sản phẩm',
            'list_dm' => $categoryModel->getAll_dm(),
            'list_nxb' => $nxbModel->getAll()
        ];
        $this->view('admin/products/add_edit_product', $data);
    }

  
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tensp = $_POST['tensp'];
            $motasp = $_POST['motasp'];
            $giasp = $_POST['giasp'];
            $ma_nxb = $_POST['ma_nxb'];
            $ma_danhmuc = $_POST['ma_danhmuc'];
            $phan_loai = $_POST['phan_loai'];
            $link_hinhanh = 'default.png'; 

 
            if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
                $file_name = $_FILES['hinh_anh']['name'];
                $file_size = $_FILES['hinh_anh']['size'];
                $tmp_name = $_FILES['hinh_anh']['tmp_name'];
                $duoi_file = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $dinh_dang = ['jpg', 'png', 'gif', 'jpeg'];
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/books/";

                if (in_array($duoi_file, $dinh_dang) && $file_size <= 20 * 1024 * 1024) {
                    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
                    
                    $new_file_name = $file_name; 
                    
                    
                    if (file_exists($target_dir . $new_file_name)) {
                        $new_file_name = time() . '_' . $file_name; 
                    }

                    if (move_uploaded_file($tmp_name, $target_dir . $new_file_name)) {
                        $link_hinhanh = $new_file_name;
                    }
                }
            }

            $productModel = $this->model('Sach');
            $productModel->add_product($tensp, $motasp, $giasp, $ma_nxb, $link_hinhanh, $ma_danhmuc, $phan_loai);

            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã thêm sách mới! Bạn có thể thêm biến thể ngay bây giờ.'];
            header("Location: /admin/sach");
            exit;
        }
    }
   
    public function edit($id) {
        $productModel = $this->model('Sach');
        $categoryModel = $this->model('Category');
        $nxbModel = $this->model('NXB');
        $dacdiemModel = $this->model('Dacdiem_sp');

        $sp_detail = $productModel->getByid($id);
        if (empty($sp_detail)) {
            header("Location: /admin/sach");
            exit;
        }

        $data = [
            'title' => 'Cập nhật Sản phẩm',
            'sp' => $sp_detail[0],
            'list_dm' => $categoryModel->getAll_dm(),
            'list_nxb' => $nxbModel->getAll(),
            'list_dacdiem_sp' => $dacdiemModel->getAll_byid_sp($id)
        ];
        $this->view('admin/products/add_edit_product', $data);
    }

 
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tensp = $_POST['tensp'];
            $motasp = $_POST['motasp'];
            $giasp = $_POST['giasp'];
            $ma_nxb = $_POST['ma_nxb'];
            $ma_danhmuc = $_POST['ma_danhmuc'];
            $phan_loai = $_POST['phan_loai'];
            $hinh_anh_cu = $_POST['hinh_anh_cu'];
            $link_hinhanh = $hinh_anh_cu;

            if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
                $file_name = $_FILES['hinh_anh']['name'];
                $duoi_file = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $dinh_dang = ['jpg', 'png', 'gif', 'jpeg'];
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/books/";

                if (in_array($duoi_file, $dinh_dang)) {
                    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

                    $new_file_name = $file_name;

                   
                    if ($new_file_name != $hinh_anh_cu && file_exists($target_dir . $new_file_name)) {
                        $new_file_name = time() . '_' . $file_name;
                    }

                    if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_dir . $new_file_name)) {
                        $link_hinhanh = $new_file_name;

                       
                        if ($hinh_anh_cu != 'default.png' && $hinh_anh_cu != $new_file_name) {
                            $old_file_path = $target_dir . $hinh_anh_cu;
                            if (file_exists($old_file_path)) {
                                unlink($old_file_path);
                            }
                        }
                    }
                }
            }

            $productModel = $this->model('Sach');
            $productModel->update_product($id, $tensp, $motasp, $giasp, $ma_nxb, $link_hinhanh, $ma_danhmuc, $phan_loai);

            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Cập nhật sản phẩm thành công!'];
            header("Location: /admin/sach/sua/" . $id);
            exit;
        }
    }

   
    public function delete($id) {
        $productModel = $this->model('Sach');
        
        
        $sp_detail = $productModel->getByid($id);
        if (!empty($sp_detail) && $sp_detail[0]['link_hinhanh'] != 'default.png') {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/books/";
            $old_file_path = $target_dir . $sp_detail[0]['link_hinhanh'];
            if (file_exists($old_file_path)) {
                unlink($old_file_path); 
            }
        }

        $productModel->delete_product($id);
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Đã xóa', 'text' => 'Sản phẩm và hình ảnh đã bị xóa khỏi hệ thống.'];
        header("Location: /admin/sach");
        exit;
    }

   
    public function addVariant() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ma_sp = (int)$_POST['ma_sp'];
            $chat_lieu = $_POST['chat_lieu'];
            $phien_ban = $_POST['phien_ban'];
            $soluong_tonkho = (int)$_POST['soluong_tonkho'];

            if (!empty($ma_sp) && !empty($chat_lieu) && !empty($phien_ban)) {
                $dacdiemModel = $this->model('Dacdiem_sp');
                $dacdiemModel->add_dacdiem($ma_sp, $chat_lieu, $phien_ban, $soluong_tonkho);
                $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đã thêm biến thể mới!'];
            }
            header("Location: /admin/sach/sua/" . $ma_sp);
            exit;
        }
    }

    public function deleteVariant($ma_dacdiem, $ma_sp) {
        $dacdiemModel = $this->model('Dacdiem_sp');
        $dacdiemModel->delete_dacdiem($ma_dacdiem);
        
        $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Đã xóa', 'text' => 'Đã xóa biến thể thành công!'];
        header("Location: /admin/sach/sua/" . $ma_sp);
        exit;
    }
}
?>