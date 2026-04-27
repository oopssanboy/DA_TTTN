<?php
class CheckoutController extends Controller
{

    public function __construct()
    {
        if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user_order']) || $_SESSION['user_order'][5] != 'bank') {
            header('Location: /gio-hang');
            exit;
        }

        $tongtien = $_SESSION['user_order'][1];
        
        $bank_id = 'Vietcombank'; 
        $account_no = '1017725187'; 
        $account_name = 'HUYNH NGOC QUAN'; 
        
       
        $ma_kh = $_SESSION['user_order'][0];
        $temp_order_id = "KH" . $ma_kh . "T" . time(); 
        $description = 'THANH TOAN ' . $temp_order_id; 

        $qr_url = "https://img.vietqr.io/image/{$bank_id}-{$account_no}-compact2.png?amount={$tongtien}&addInfo=" . urlencode($description) . "&accountName=" . urlencode($account_name);

        $data = [
            'title' => 'Thanh toán chuyển khoản - Chapter One',
            'tongtien' => $tongtien,
            'qr_url' => $qr_url, 
            'account_no' => $account_no,
            'bank_id' => $bank_id,
            'account_name' => $account_name,
            'description' => $description
        ];

        $this->view('user/checkout/index', $data); 
    }

    public function confirmPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_order'])) {

            $ma_kh = $_SESSION['user_order'][0];
            $tongtien = $_SESSION['user_order'][1];

            $order = $this->model('Order');
            $order_item = $this->model('Order_item');
            $cart = $this->model('Cart');
            $dacdiem_sp = $this->model('Dacdiem_sp');

            $list_cart = $cart->getAllcart_info_byid($ma_kh);
          
            $trangthai = 'choxuly';

            $ma_dh = $order->add_order($_SESSION['user_order'][0], $_SESSION['user_order'][1], $_SESSION['user_order'][2], $_SESSION['user_order'][3], $trangthai, $_SESSION['user_order'][5], $_SESSION['user_order'][6], $_SESSION['user_order'][7], $_SESSION['user_order'][8], $_SESSION['user_order'][9], $_SESSION['user_order'][10]);

            foreach ($list_cart as $item) {
                $order_item->add_order_item($item['ma_sp'], $ma_dh, $item['chat_lieu'], $item['soluong'], $item['giasp'], $item['phien_ban']);
                $dacdiem_sp->update_tonkho($item['ma_sp'], $item['chat_lieu'], $item['phien_ban'], $item['soluong'], 'giam');
            }

            
            $this->sendOrderEmail($ma_dh, $tongtien, 'Chuyển khoản ngân hàng');

            $cart->del_byid_kh($ma_kh);
            $_SESSION['user_cart']['count'] = 0;
            unset($_SESSION['user_order']);

            $_SESSION['flash_alert'] = [
                'title' => 'Thành công!',
                'text' => 'Đã ghi nhận yêu cầu thanh toán. Chúng tôi sẽ xử lý sớm.',
                'icon' => 'success'
            ];

            header("Location: /gio-hang");
            exit;
        } else {
            header("Location: /gio-hang");
            exit;
        }
    }


    public function momoPayment()
    {
        if (!isset($_SESSION['user_order']) || $_SESSION['user_order'][5] != 'momo') {
            header('Location: /gio-hang');
            exit;
        }

        $tongtien = $_SESSION['user_order'][1];
        $ma_kh = $_SESSION['user_order'][0];

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMONPMB20210629";
        $accessKey = "Q2XhhSdgpKUlQ4Ky";
        $secretKey = "k6B53GQKSjktZGJBK2MyrDa7w9S6RyCf";

        $orderInfo = "Thanh_toan_don_hang";
        $amount = (string) $tongtien;
        $orderId = time() . "_KH" . $ma_kh; 
        $redirectUrl = "https://huynhngocquan.id.vn/xac-nhan-momo"; 
        $ipnUrl = "https://huynhngocquan.id.vn/xac-nhan-momo";
        $redirectUrl = trim($redirectUrl);
        $ipnUrl = trim($ipnUrl);
        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = "";

        $rawHash = sprintf(
            "accessKey=%s&amount=%s&extraData=%s&ipnUrl=%s&orderId=%s&orderInfo=%s&partnerCode=%s&redirectUrl=%s&requestId=%s&requestType=%s",
            $accessKey,
            $amount,
            $extraData,
            $ipnUrl,
            $orderId,
            $orderInfo,
            $partnerCode,
            $redirectUrl,
            $requestId,
            $requestType
        );
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Chapter One - The Beginning",
            "storeId" => "MOMONPMB20210629_1",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);
        curl_close($ch);

        $jsonResult = json_decode($result, true);
        
        if (isset($jsonResult['payUrl'])) {
            header('Location: ' . $jsonResult['payUrl']);
            exit;
        } else {
            $_SESSION['flash_alert'] = ['title' => 'Lỗi kết nối', 'text' => 'Không thể tải cổng thanh toán MoMo lúc này.', 'icon' => 'error'];
            header('Location: /gio-hang');
            exit;
        }
    }

   
    public function momoReturn()
    {
        $resultCode = isset($_GET['resultCode']) ? $_GET['resultCode'] : null;

        if ($resultCode === '0' && isset($_SESSION['user_order'])) {
           
            $ma_kh = $_SESSION['user_order'][0];
            $tongtien = $_SESSION['user_order'][1];

            $order = $this->model('Order');
            $order_item = $this->model('Order_item');
            $cart = $this->model('Cart');
            $dacdiem_sp = $this->model('Dacdiem_sp');

            $list_cart = $cart->getAllcart_info_byid($ma_kh);

            $trangthai = 'choxuly';
            $ma_dh = $order->add_order($_SESSION['user_order'][0], $_SESSION['user_order'][1], $_SESSION['user_order'][2], $_SESSION['user_order'][3], $trangthai, 'momo', $_SESSION['user_order'][6], $_SESSION['user_order'][7], $_SESSION['user_order'][8], $_SESSION['user_order'][9], $_SESSION['user_order'][10]);

            foreach ($list_cart as $item) {
                $order_item->add_order_item($item['ma_sp'], $ma_dh, $item['size'], $item['soluong'], $item['giasp'], $item['loai_mau']);
                $dacdiem_sp->update_tonkho($item['ma_sp'], $item['size'], $item['loai_mau'], $item['soluong'], 'giam');
            }

            
            $this->sendOrderEmail($ma_dh, $tongtien, 'Ví điện tử MoMo');

            $cart->del_byid_kh($ma_kh);
            $_SESSION['user_cart']['count'] = 0;
            unset($_SESSION['user_order']); 

            $_SESSION['flash_alert'] = ['title' => 'Thành công!', 'text' => 'Thanh toán MoMo thành công.', 'icon' => 'success'];
            header("Location: /gio-hang");
            exit;

        } else {
            $_SESSION['flash_alert'] = ['title' => 'Thất bại', 'text' => 'Giao dịch MoMo bị hủy hoặc không thành công.', 'icon' => 'error'];
            header("Location: /gio-hang");
            exit;
        }
    }

    private function sendOrderEmail($ma_dh, $tongtien, $pttt) 
    {
        $email_kh = $_SESSION['user_info']['email'] ?? ($_SESSION['user_info'][0]['email'] ?? '');
        $ten_kh = $_SESSION['user_info']['ten_kh'] ?? ($_SESSION['user_info'][0]['ten_kh'] ?? 'Quý khách');

        if (!empty($email_kh)) {
            require_once ROOT_DIR . '/app/helpers/Mailer.php';
            
            $tongtien_fm = number_format($tongtien) . ' ₫';
            $subject = "Xác nhận đơn hàng #{$ma_dh} - Chapter One";
            
            $content = "
            <div style='font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; background-color: #f4f5f7; color: #333;'>
                <div style='max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border-top: 5px solid #d97706; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                    <h2 style='color: #d97706; text-align: center; margin-bottom: 20px;'>ĐẶT HÀNG THÀNH CÔNG</h2>
                    <p>Xin chào <strong>{$ten_kh}</strong>,</p>
                    <p>Cảm ơn bạn đã tin tưởng và mua sách tại <strong>Chapter One</strong>. Đơn hàng của bạn đã được hệ thống ghi nhận và đang trong quá trình xử lý.</p>
                    
                    <div style='background: #fafafa; padding: 20px; border-radius: 5px; margin: 25px 0; border: 1px solid #eee;'>
                        <h3 style='margin-top: 0; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;'>Thông tin đơn hàng</h3>
                        <p style='margin: 10px 0;'><strong>Mã đơn hàng:</strong> <span style='color: #d97706; font-weight: bold;'>#{$ma_dh}</span></p>
                        <p style='margin: 10px 0;'><strong>Phương thức thanh toán:</strong> {$pttt}</p>
                        <p style='margin: 10px 0; font-size: 16px;'><strong>Tổng thanh toán:</strong> <span style='color: #d0011b; font-weight: bold;'>{$tongtien_fm}</span></p>
                    </div>
                    
                    <p>Chúng tôi sẽ sớm liên hệ hoặc gửi email thông báo khi đơn hàng được bàn giao cho đơn vị vận chuyển.</p>
                    <p style='margin-top: 30px;'>Trân trọng,<br><strong style='color: #d97706;'>Đội ngũ Chapter One</strong></p>
                </div>
            </div>";
            Mailer::sendMail($email_kh, $subject, $content);
        }
    }
}
?>