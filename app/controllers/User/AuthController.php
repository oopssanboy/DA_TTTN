<?php

class AuthController extends Controller
{

    // 1. Hiển thị form đăng nhập
    public function login()
    {
        if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
            header('Location: /');
            exit;
        }
        $this->view('user/auth/login', ['title' => 'Đăng nhập - Chapter One']);
    }

    // 2. Xử lý logic đăng nhập
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $matkhau = $_POST['matkhau'] ?? '';

            $userModel = $this->model('User');
            $user = $userModel->checkLogin($email, $matkhau);

            if ($user) {
                // ==========================================
                // KIỂM TRA TRẠNG THÁI KHÓA TÀI KHOẢN
                // ==========================================
                if (isset($user['trangthai']) && $user['trangthai'] == 'dakhoa') {
                    $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Từ chối truy cập', 'text' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Admin!'];
                    header('Location: /dang-nhap');
                    exit;
                }

                // Lưu thông tin cơ bản
                $_SESSION['user_info'] = $user;

                // Xử lý Avatar
                if (!empty($user['avatar'])) {
                    if (filter_var($user['avatar'], FILTER_VALIDATE_URL)) {
                        $_SESSION['user_avatar'] = $user['avatar'];
                    } else {
                        $_SESSION['user_avatar'] = URLROOT . '/uploads/avatars/' . $user['avatar'];
                    }
                } else {
                    $_SESSION['user_avatar'] = URLROOT . '/assets/user/img/dora.png';
                }

                // LẤY SỐ LƯỢNG GIỎ HÀNG TỪ DATABASE
                $cartModel = $this->model('Cart');
                $list_cart = $cartModel->getAllcart_info_byid($user['ma_kh']);
                $total_qty = 0;

                if ($list_cart != null) {
                    foreach ($list_cart as $item) {
                        $total_qty += $item['soluong']; // Cộng dồn số lượng từng món
                    }
                }

                // Khởi tạo session giỏ hàng
                $_SESSION['user_cart'] = [
                    'count' => $total_qty
                ];

                // Phân quyền (Role: 1 là Admin, 0 là User)
                if ($user['role'] == 1) {
                    $_SESSION['admin_login'] = true;
                    $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Xin chào Admin', 'text' => 'Đăng nhập thành công!'];
                    header('Location: /admin');
                } else {
                    $_SESSION['user_login'] = true;
                    $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Thành công', 'text' => 'Đăng nhập thành công!'];
                    header('Location: /');
                }
                exit;
            } else {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Email hoặc mật khẩu không chính xác!'];
                header('Location: /dang-nhap');
                exit;
            }
        }
    }

    // 3. Hiển thị form đăng ký
    public function register()
    {
        if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
            header('Location: /');
            exit;
        }
        $this->view('user/auth/register', ['title' => 'Đăng ký - Chapter One']);
    }

    // 4. Xử lý logic đăng ký
    public function processRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_kh = isset($_POST['ten_kh']) ? $_POST['ten_kh'] : null;
            $email = $_POST['email'];
            $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : null;
            $diachi = isset($_POST['diachi']) ? $_POST['diachi'] : null;
            $matkhau = $_POST['matkhau'];
            $xacnhan_matkhau = $_POST['xacnhan_matkhau'];

            if ($matkhau !== $xacnhan_matkhau) {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Mật khẩu xác nhận không khớp!'];
                header('Location: /dang-ky');
                exit;
            }

            $userModel = $this->model('User');
            if ($userModel->checkEmailExist($email)) {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Thất bại', 'text' => 'Email này đã được sử dụng!'];
                header('Location: /dang-ky');
                exit;
            }

            // 1. Tạo mã OTP ngẫu nhiên 6 số
            $otp = rand(100000, 999999);

            // 2. Lưu tạm thông tin người dùng và OTP vào Session (Hết hạn sau 5 phút)
            $_SESSION['register_temp'] = [
                'ten_kh' => $ten_kh,
                'email' => $email,
                'sdt' => $sdt,
                'diachi' => $diachi,
                'matkhau' => $matkhau,
                'otp' => $otp,
                'expires' => time() + 300 // 5 phút
            ];

            // 3. Gọi helper gửi Email
            require_once ROOT_DIR . '/app/helpers/Mailer.php';
            $subject = "Mã xác thực đăng ký tài khoản - Chapter One";
            $content = "<div style='font-family: Arial, sans-serif; padding: 20px; line-height: 1.6;'>
                            <h2 style='color: #333;'>Xin chào {$ten_kh},</h2>
                            <p>Bạn đang thực hiện đăng ký tài khoản tại hệ thống của chúng tôi.</p>
                            <p>Mã xác thực OTP của bạn là: <strong style='font-size: 24px; color: #d0011b; letter-spacing: 2px;'>{$otp}</strong></p>
                            <p style='color: #888;'>Mã này sẽ hết hạn trong vòng 5 phút. Vui lòng không chia sẻ mã này cho bất kỳ ai để bảo mật tài khoản.</p>
                        </div>";

            Mailer::sendMail($email, $subject, $content);

            header('Location: /xac-thuc-otp');
            exit;
        }
    }
    // THÊM MỚI: Hiển thị form nhập OTP
    public function verifyOTP()
    {
        if (!isset($_SESSION['register_temp'])) {
            header('Location: /dang-ky');
            exit;
        }
        $this->view('user/auth/verify_otp', ['title' => 'Xác thực OTP - Chapter One']);
    }

    // THÊM MỚI: Xử lý xác nhận OTP và Lưu chính thức vào DB
    public function processVerifyOTP()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $otp_input = $_POST['otp'] ?? '';

            if (!isset($_SESSION['register_temp'])) {
                header('Location: /dang-ky');
                exit;
            }

            $temp_data = $_SESSION['register_temp'];

            // Kiểm tra thời gian hết hạn
            if (time() > $temp_data['expires']) {
                unset($_SESSION['register_temp']);
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Hết hạn', 'text' => 'Mã OTP đã hết hạn. Vui lòng đăng ký lại!'];
                header('Location: /dang-ky');
                exit;
            }

            // Kiểm tra tính hợp lệ của mã
            if ($otp_input == $temp_data['otp']) {
                $userModel = $this->model('User');
                $result = $userModel->register($temp_data['ten_kh'], $temp_data['email'], $temp_data['matkhau'], $temp_data['sdt'], $temp_data['diachi']);

                if ($result) {
                    unset($_SESSION['register_temp']); // Xóa dữ liệu tạm
                    $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Tuyệt vời', 'text' => 'Đăng ký thành công. Vui lòng đăng nhập!'];
                    header('Location: /dang-nhap');
                } else {
                    $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Không thể tạo tài khoản lúc này.'];
                    header('Location: /dang-ky');
                }
            } else {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Sai mã', 'text' => 'Mã OTP không chính xác!'];
                header('Location: /xac-thuc-otp');
            }
            exit;
        }
    }

    // 5. Đăng xuất
    public function logout()
    {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['flash_alert'] = ['icon' => 'info', 'title' => 'Tạm biệt', 'text' => 'Bạn đã đăng xuất an toàn.'];
        header('Location: /dang-nhap');
        exit;
    }
    private function getGoogleClient()
    {
        $client = new \Google_Client();
        $client->setClientId('929628426936-dqcpvn0avfsbbs9pq151c94arc3d4ave.apps.googleusercontent.com');
        $client->setClientSecret('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');

        // Trỏ về đúng đường dẫn MVC
        $redirect_uri = URLROOT . '/auth/google/callback';
        $client->setRedirectUri($redirect_uri);

        // Tắt verify SSL trên localhost (Giống code cũ của bạn)
        $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
        $client->setHttpClient($guzzleClient);

        $client->addScope("email");
        $client->addScope("profile");
        return $client;
    }

    public function loginGoogle()
    {
        $client = $this->getGoogleClient();
        $url = $client->createAuthUrl();
        header('Location: ' . filter_var($url, FILTER_SANITIZE_URL));
        exit;
    }

    public function googleCallback()
    {
        if (isset($_GET['code'])) {
            $client = $this->getGoogleClient();
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (!isset($token['error'])) {
                $client->setAccessToken($token['access_token']);
                $google_oauth = new \Google_Service_Oauth2($client);
                $google_info = $google_oauth->userinfo->get();

                $email = $google_info->email;
                $name = $google_info->name;
                $avatar = $google_info->picture;
                $token_str = json_encode($token);

                $this->handleSocialLogin($name, $email, $avatar, $token_str, 'google');
            } else {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Đăng nhập Google thất bại!'];
                header('Location: /dang-nhap');
                exit;
            }
        }
    }

    // ==========================================
    // ĐĂNG NHẬP BẰNG FACEBOOK
    // ==========================================
    private function getFacebookClient()
    {
        return new \Facebook\Facebook([
            'app_id' => '1290514812929698',
            'app_secret' => 'de94d39c2646632fb85d7d224ecede58',
            'default_graph_version' => 'v19.0',
        ]);
    }

    public function loginFacebook()
    {
        $fb = $this->getFacebookClient();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'public_profile'];

        // Trỏ về đúng đường dẫn MVC
        $callbackUrl = URLROOT . '/auth/facebook/callback';
        $loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);

        header('Location: ' . $loginUrl);
        exit;
    }

    public function facebookCallback()
    {
        $fb = $this->getFacebookClient();
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Exception $e) {
            $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi Facebook', 'text' => $e->getMessage()];
            header('Location: /dang-nhap');
            exit;
        }

        if (!isset($accessToken)) {
            $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi', 'text' => 'Không thể xác thực từ Facebook.'];
            header('Location: /dang-nhap');
            exit;
        }

        try {
            $response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken->getValue());
            $fbUser = $response->getGraphUser();

            $name = $fbUser->getField('name');
            $email = $fbUser->getField('email');

            // Lấy link Avatar FB
            $avatar = '';
            $picture = $fbUser->getField('picture');
            if ($picture && !$picture->isSilhouette()) {
                $avatar = $picture->getUrl();
            }

            // Xử lý nếu user đăng ký FB bằng SĐT (Không có email)
            if (empty($email)) {
                $email = $fbUser->getField('id') . '@facebook.com';
            }

            $token_str = $accessToken->getValue();

            $this->handleSocialLogin($name, $email, $avatar, $token_str, 'facebook');

        } catch (\Exception $e) {
            $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Lỗi Dữ Liệu', 'text' => $e->getMessage()];
            header('Location: /dang-nhap');
            exit;
        }
    }

    // ==========================================
    // HÀM XỬ LÝ CHUNG LƯU DATABASE
    // ==========================================
    private function handleSocialLogin($name, $email, $avatar, $token, $provider)
    {
        $userModel = $this->model('User');
        $checkUser = $userModel->checkEmailExist($email);

        if ($checkUser) {
            // KIỂM TRA KHÓA TÀI KHOẢN
            if (isset($checkUser['trangthai']) && $checkUser['trangthai'] == 'dakhoa') {
                $_SESSION['flash_alert'] = ['icon' => 'error', 'title' => 'Bị khóa', 'text' => 'Tài khoản của bạn đã bị khóa!'];
                header('Location: /dang-nhap');
                exit;
            }

            // Dùng hàm cập nhật của bạn
            $userModel->update_token($checkUser['ma_kh'], $token);
            if (empty($checkUser['avatar'])) {
                $userModel->update_avatar($avatar, $checkUser['ma_kh']);
            }
            $_SESSION['user_info'] = $checkUser;
            $_SESSION['user_avatar'] = !empty($checkUser['avatar']) ? $checkUser['avatar'] : $avatar;
        } else {
            // TẠO TÀI KHOẢN MỚI
            // Gợi ý: Chắc chắn hàm add_user_social / add_user_google trong User.class.php của bạn đã hỗ trợ truyền biến $avatar
            $userModel->add_user_social($name, $email, $token, $avatar);
            $newUser = $userModel->checkEmailExist($email);
            $_SESSION['user_info'] = $newUser;
            $_SESSION['user_avatar'] = $avatar;
        }

        // Lấy số lượng giỏ hàng
        $ma_kh = $_SESSION['user_info']['ma_kh'];
        $cartModel = $this->model('Cart');
        $list_cart = $cartModel->getAllcart_info_byid($ma_kh);
        $total_qty = 0;

        if ($list_cart != null) {
            foreach ($list_cart as $item) {
                $total_qty += $item['soluong'];
            }
        }

        $_SESSION['user_cart'] = ['count' => $total_qty];

        // Phân quyền
        if ($_SESSION['user_info']['role'] == 1) {
            $_SESSION['admin_login'] = true;
            header('Location: /admin');
        } else {
            $_SESSION['user_login'] = true;
            $_SESSION['flash_alert'] = ['icon' => 'success', 'title' => 'Xin chào!', 'text' => 'Đăng nhập thành công.'];
            header('Location: /');
        }
        exit;
    }
}
?>