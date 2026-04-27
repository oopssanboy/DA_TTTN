<?php
class CartController extends Controller {

 
    public function __construct() {
        if (!isset($_SESSION['user_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }


    public function index() {
        $cart_model = $this->model('Cart');
        $ma_kh = $_SESSION['user_info']['ma_kh'];
        
        $list_cart = $cart_model->getAllcart_info_byid($ma_kh);
        
        $sum_money = 0;
        $sum_product = 0;
        
        if ($list_cart != null) {
            foreach ($list_cart as $cart) {
                $sum_money += $cart['giasp'] * $cart['soluong'];
                $sum_product += $cart['soluong'];
            }
        }

        $data = [
            'title' => 'Giỏ hàng của bạn - Chapter One',
            'list_cart' => $list_cart,
            'sum_money' => $sum_money,
            'sum_product' => $sum_product,
            'date_now' => date('Y-m-d'),
            'date' => date('Y-m-d', strtotime('+3 days'))
        ];

        $this->view('user/cart/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ma_sp'])) {
            $ma_sp = $_POST['ma_sp'];
            $ma_kh = $_SESSION['user_info']['ma_kh'];
            $phien_ban = $_POST['phien_ban'];
            $chat_lieu = $_POST['chat_lieu'];
            $soluong = $_POST['soluong'];
            
            $cart = $this->model('Cart');
            $cart->add($ma_kh, $ma_sp, $chat_lieu, $phien_ban, $soluong);
            
            $_SESSION['user_cart']['count'] += $soluong;
            $_SESSION['flash_alert'] = [
                'title' => 'Thành công!',
                'text' => 'Bạn đã thêm sản phẩm.',
                'icon' => 'success'
            ];
            
            header("Location: /san-pham/chi-tiet/$ma_sp");
            exit;
        }
    }

    public function updateQty($ma_cart, $type) {
        $cart = $this->model('Cart');
        $dacdiem_sp = $this->model('Dacdiem_sp');
        
        $cart_item = $cart->getByid($ma_cart);

        if ($cart_item) {
            $current_item = $cart_item[0];
            $current_qty = $current_item['soluong'];
            $new_qty = $current_qty;

            if ($type == 'increase') {
                $info_product = $dacdiem_sp->getAll_byid_sp($current_item['ma_sp']);
                $tonkho = 0;
                foreach ($info_product as $pr) {
                    if ($current_item['chat_lieu'] == $pr['chat_lieu'] && $current_item['phien_ban'] == $pr['phien_ban']) {
                        $tonkho = $pr['soluong_tonkho'];
                        break;
                    }
                }

                if ($current_qty < $tonkho) {
                    $new_qty++;
                }

            } elseif ($type == 'decrease') {
                if ($current_qty > 1) {
                    $new_qty--;
                }
            }

            if ($new_qty != $current_qty) {
                $cart->update_soluong($ma_cart, $new_qty);
                if (isset($_SESSION['user_cart']['count'])) {
                    $_SESSION['user_cart']['count'] += ($new_qty - $current_qty);
                }
            }
        }
        header("Location: /gio-hang");
        exit;
    }

    public function delete($ma_cart) {
        $cart = $this->model('Cart');
        
        $cart_item = $cart->getByid($ma_cart);
        $soluong_del = 0;
        if($cart_item){
            $soluong_del = $cart_item[0]['soluong'];
        }

        $cart->del($ma_cart);
        
        $_SESSION['user_cart']['count'] -= $soluong_del;
        $_SESSION['flash_alert'] = [
            'title' => 'Thành công!',
            'text' => 'Bạn đã xóa sản phẩm.',
            'icon' => 'success'
        ];
        
        header("Location: /gio-hang");
        exit;
    }

    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ma_kh = $_POST['ma_kh'];
            $ten_kh = $_POST['ten_kh'];
            $tongtien = $_POST['tongtien'];
            $email = $_POST['email'];
            $tongsp = $_POST['tongsp'];
            $trangthai = 'choxuly';
            $phuongthuc_thanhtoan = $_POST['pttt'];
            $ngay_dat = $_POST['ngay_dat'];
            $ngay_giaohang = $_POST['ngay_giaohang'];
            $diachi_giaohang = $_POST['diachi'];
            $sdt = $_POST['sdt'];

            $_SESSION['user_order'] = [$ma_kh, $tongtien, $email, $tongsp, $trangthai, $phuongthuc_thanhtoan, $ngay_dat, $ngay_giaohang, $sdt, $ten_kh, $diachi_giaohang];

            $cart = $this->model('Cart');
            $dacdiem_sp = $this->model('Dacdiem_sp');
            $order = $this->model('Order');
            $order_item = $this->model('Order_item');
            
            $list_cart = $cart->getAllcart_info_byid($ma_kh);

            $flag = 0;
            foreach ($list_cart as $it) {
                $info_product = $dacdiem_sp->getAll_byid_sp($it['ma_sp']);
                foreach ($info_product as $pr) {
                    if ($it['chat_lieu'] == $pr['chat_lieu'] && $it['phien_ban'] == $pr['phien_ban']) {
                        if (($pr['soluong_tonkho'] - $it['soluong']) >= 0) {
                            $flag++;
                        } else {
                            $_SESSION['flash_alert'] = [
                                'title' => 'Thất bại!', 'text' => 'Sản phẩm hết hàng.', 'icon' => 'error'
                            ];
                            header("Location: /gio-hang");
                            exit;
                        }
                    }
                }
            }

            if ($flag > 0) {
                if ($phuongthuc_thanhtoan == 'ttknh') {
                  
                    $ma_dh = $order->add_order($_SESSION['user_order'][0], $_SESSION['user_order'][1], $_SESSION['user_order'][2], $_SESSION['user_order'][3], $_SESSION['user_order'][4], $_SESSION['user_order'][5], $_SESSION['user_order'][6], $_SESSION['user_order'][7], $_SESSION['user_order'][8], $_SESSION['user_order'][9], $_SESSION['user_order'][10]);
                    
                    foreach ($list_cart as $item) {
                        $order_item->add_order_item($item['ma_sp'], $ma_dh, $item['chat_lieu'], $item['soluong'], $item['giasp'], $item['phien_ban']);
                        $dacdiem_sp->update_tonkho($item['ma_sp'], $item['chat_lieu'], $item['phien_ban'], $item['soluong'], 'giam');
                    }

                
                    $email_kh = $_SESSION['user_info']['email'] ?? ($_SESSION['user_info'][0]['email'] ?? '');
                    $ten_kh = $_SESSION['user_info']['ten_kh'] ?? ($_SESSION['user_info'][0]['ten_kh'] ?? 'Quý khách');
                    $tongtien_fm = number_format($_SESSION['user_order'][1]) . ' ₫';

                    if (!empty($email_kh)) {
                        require_once ROOT_DIR . '/app/helpers/Mailer.php';
                        $subject = "Xác nhận đơn hàng #{$ma_dh} - Chapter One";
                        $content = "
                        <div style='font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; background-color: #f4f5f7; color: #333;'>
                            <div style='max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border-top: 5px solid #d97706; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                                <h2 style='color: #d97706; text-align: center; margin-bottom: 20px;'>ĐẶT HÀNG THÀNH CÔNG</h2>
                                <p>Xin chào <strong>{$ten_kh}</strong>,</p>
                                <p>Cảm ơn bạn đã tin tưởng và mua sách tại <strong>Chapter One</strong>. Đơn hàng của bạn đã được ghi nhận với phương thức <strong>Thanh toán khi nhận hàng (COD)</strong>.</p>
                                
                                <div style='background: #fafafa; padding: 20px; border-radius: 5px; margin: 25px 0; border: 1px solid #eee;'>
                                    <h3 style='margin-top: 0; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;'>Thông tin đơn hàng</h3>
                                    <p style='margin: 10px 0;'><strong>Mã đơn hàng:</strong> <span style='color: #d97706; font-weight: bold;'>#{$ma_dh}</span></p>
                                    <p style='margin: 10px 0;'><strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng (COD)</p>
                                    <p style='margin: 10px 0; font-size: 16px;'><strong>Tổng thanh toán:</strong> <span style='color: #d0011b; font-weight: bold;'>{$tongtien_fm}</span></p>
                                </div>
                                
                                <p>Chúng tôi sẽ chuẩn bị hàng và giao đến bạn trong thời gian sớm nhất.</p>
                                <p style='margin-top: 30px;'>Trân trọng,<br><strong style='color: #d97706;'>Đội ngũ Chapter One</strong></p>
                            </div>
                        </div>";
                        Mailer::sendMail($email_kh, $subject, $content);
                    }
                    
                    $cart->del_byid_kh($ma_kh);
                    $_SESSION['user_cart']['count'] = 0;
                    unset($_SESSION['user_order']);
                    
                    $_SESSION['flash_alert'] = [
                        'title' => 'Thành công!', 'text' => 'Bạn đã đặt hàng thành công.', 'icon' => 'success'
                    ];
                    header("Location: /gio-hang");
                    exit;
                    
                } else if ($phuongthuc_thanhtoan == 'bank') {
                   
                    header("Location: /thanh-toan-qr");
                    exit;
                } else if ($phuongthuc_thanhtoan == 'momo') {
                
                header("Location: /thanh-toan-momo");
                exit;
                }
            }
        }
    }
}
?>