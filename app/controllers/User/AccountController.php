<?php
class AccountController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    public function index() {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'info';
        $ma_kh = $_SESSION['user_info']['ma_kh'];

        $userModel = $this->model('User');
        $user_info = $userModel->get_user_byid($ma_kh);
        
        $data = [
            'title' => 'Quản lý tài khoản',
            'tab' => $tab,
            'user_info' => $user_info[0] ?? $_SESSION['user_info']
        ];

  
        if ($tab == 'xem_donhang') {
            $orderModel = $this->model('Order');
            $data['list_order'] = $orderModel->getAll_Byid_kh($ma_kh);
        }

        if ($tab == 'xem_chitiet' && isset($_GET['ma_dh'])) {
            $ma_dh = (int)$_GET['ma_dh'];
            $orderModel = $this->model('Order');
            $orderItemModel = $this->model('Order_item');

            $data['order_info'] = $orderModel->getByid($ma_dh);
            $data['items'] = $orderItemModel->getAll_orderitem_info_byid($ma_dh);
            $data['ma_dh'] = $ma_dh;
        }

        $this->view('user/account/index', $data);
    }

    public function updateInfo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_kh = trim($_POST['ten_kh'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sdt = trim($_POST['sdt'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');

            if (!empty($ten_kh) && !empty($email) && !empty($sdt) && !empty($dia_chi)) {
                $userModel = $this->model('User');
                $ma_kh = $_SESSION['user_info']['ma_kh'];
  
                $userModel->update_info($ten_kh, $email, $sdt, $dia_chi, $ma_kh);
                
                $_SESSION['user_info']['ten_kh'] = $ten_kh;
                $_SESSION['user_info']['email'] = $email;
                $_SESSION['user_info']['sdt'] = $sdt;
                $_SESSION['user_info']['dia_chi'] = $dia_chi;

                $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Đã cập nhật thông tin.', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi!', 'text' => 'Vui lòng điền đủ thông tin.', 'icon' => 'error'];
            }
            header('Location: /tai-khoan?tab=change_info');
            exit;
        }
    }

    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pass = $_POST['pass_new'] ?? '';
            $passconfirm = $_POST['pass_confirm'] ?? '';

            if ($pass === $passconfirm && !empty($pass)) {
                $userModel = $this->model('User');
                $ma_kh = $_SESSION['user_info']['ma_kh'];
                
                $userModel->update_password($pass, $ma_kh);
                
                $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Đã đổi mật khẩu an toàn.', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi!', 'text' => 'Mật khẩu xác nhận không khớp.', 'icon' => 'error'];
            }
            header('Location: /tai-khoan?tab=change_pass');
            exit;
        }
    }


    public function cancelOrder($ma_dh) {
        $orderModel = $this->model('Order');
        $orderItemModel = $this->model('Order_item');
        $dacdiem_sp = $this->model('Dacdiem_sp');
        $ma_kh = $_SESSION['user_info']['ma_kh'];

        $orderInfo = $orderModel->getByid($ma_dh);
        
        if (!empty($orderInfo) && $orderInfo[0]['ma_kh'] == $ma_kh) {
            $trangthai = $orderInfo[0]['trangthai'];
            
            if ($trangthai != 'huy' && $trangthai != 'dagiao' && $trangthai != 'daxacnhan') {
                $data_item = $orderItemModel->getAll_orderitem_info_byid($ma_dh);
             
                foreach ($data_item as $v) {
                    $dacdiem_sp->update_tonkho($v['ma_sp'], $v['chat_lieu'], $v['phien_ban'], $v['soluong'], 'tang');
                }
           
                $orderModel->update_order($ma_dh, 'huy');
                
                $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Đã hủy đơn hàng.', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Từ chối!', 'text' => 'Đơn hàng này không thể hủy.', 'icon' => 'error'];
            }
        }
        
        header('Location: /tai-khoan?tab=xem_donhang');
        exit;
    }
    public function doiAvatar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar_file'])) {
            
            if (!isset($_SESSION['user_login'])) {
                header('Location: /dang-nhap');
                exit;
            }
            require_once ROOT_DIR . '/app/helpers/UploadHelper.php';
            $ma_kh = $_SESSION['user_info']['ma_kh'];

          
            $uploadResult = UploadHelper::uploadImage($_FILES['avatar_file'], 'avatars');

            if ($uploadResult['success'] === true) {
                
                $userModel = $this->model('User'); 
                $avatar_path = $uploadResult['path']; 
               
                $userModel->update_avatar($avatar_path, $ma_kh);

                $_SESSION['user_avatar'] = $avatar_path;
                $_SESSION['user_avatar'] = URLROOT . '/uploads/avatars/' . $avatar_path;
                $_SESSION['flash_alert'] = ['title' => 'Thành công', 'text' => 'Cập nhật ảnh đại diện thành công!', 'icon' => 'success'];
                
            } else {
             
                $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => $uploadResult['message'], 'icon' => 'error'];
            }

            header("Location: /tai-khoan");
            exit;
        }
    }
}
?>