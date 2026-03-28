<?php
if (!isset($_SESSION)) session_start();

// Nạp file autoload trung tâm từ thư mục app/core
require_once dirname(__DIR__) . '/app/core/autoload.php';

$router = new \Bramus\Router\Router();
$router->setBasePath('/');
// ==========================================
// 1. GIAO DIỆN KHÁCH HÀNG (CLIENT)-----------------------------------------------------
// ==========================================
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/danh-muc', function() { (new ShopController())->index(); });

// Bắt ID sản phẩm và truyền vào hàm detail() của ProductController
$router->get('/san-pham/chi-tiet/(\d+)', function($id) {
    $controller = new ProductController();
    $controller->detail($id);
});

$router->get('/gio-hang', function() {
    $controller = new CartController();
    $controller->index();
});
$router->post('/gio-hang/them', function() {
    $controller = new CartController();
    $controller->add();
});

// 3. Route cập nhật số lượng (+ / -)
$router->get('/gio-hang/cap-nhat/(\d+)/(increase|decrease)', function($ma_cart, $type) {
    $controller = new CartController();
    $controller->updateQty($ma_cart, $type);
});

// 4. Route xóa sản phẩm khỏi giỏ
$router->get('/gio-hang/xoa/(\d+)', function($ma_cart) {
    $controller = new CartController();
    $controller->delete($ma_cart);
});
$router->post('/gio-hang/thanh-toan', function() {
    $controller = new CartController();
    $controller->checkout();
});

$router->get('/thanh-toan', function() {
    $controller = new CheckoutController();
    $controller->index();
});
$router->post('/xac-nhan-thanh-toan', function() {
    $controller = new CheckoutController();
    $controller->confirmPayment();
});
$router->get('/gioi-thieu', function() {
    $controller = new HomeController();
    $controller->gioithieu();
});

$router->get('/lien-he', function() {
    $controller = new HomeController();
    $controller->lienhe();
});
$router->get('/tin-tuc', function() {
    $controller = new HomeController();
    $controller->tintuc();
});
// ==========================================
// 2. CHỨC NĂNG TÀI KHOẢN (AUTH)
// ==========================================
$router->get('/dang-nhap', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->post('/xuly-dangnhap', function() {
    $controller = new AuthController();
    $controller->processLogin();
});

$router->get('/dang-ky', function() {
    $controller = new AuthController();
    $controller->register();
});

$router->post('/xuly-dangky', function() {
    $controller = new AuthController();
    $controller->processRegister();
});

$router->get('/dang-xuat', function() {
    $controller = new AuthController();
    $controller->logout();
});
// Link bấm vào để chuyển hướng sang Google / Facebook
$router->get('/auth/google', function() { (new AuthController())->loginGoogle(); });
$router->get('/auth/facebook', function() { (new AuthController())->loginFacebook(); });

// Link hứng dữ liệu (Callback) khi Google / Facebook trả về
$router->get('/auth/google/callback', function() { (new AuthController())->googleCallback(); });
$router->get('/auth/facebook/callback', function() { (new AuthController())->facebookCallback(); });
$router->get('/tai-khoan', function() {
    $controller = new AccountController();
    $controller->index();
});

// Route xử lý form Cập nhật thông tin
$router->post('/tai-khoan/cap-nhat-thong-tin', function() {
    $controller = new AccountController();
    $controller->updateInfo();
});

// Route xử lý form Đổi mật khẩu
$router->post('/tai-khoan/doi-mat-khau', function() {
    $controller = new AccountController();
    $controller->updatePassword();
});

// Route Hủy đơn hàng
$router->get('/tai-khoan/huy-don/(\d+)', function($ma_dh) {
    $controller = new AccountController();
    $controller->cancelOrder($ma_dh);
});




// ==========================================
// QUẢN TRỊ VIÊN (ADMIN)
// ==========================================
$router->mount('/admin', function() use ($router) {
        
    // 1. Thống kê (Dashboard)
    $router->get('/', function() {
        $controller = new DashboardController();
        $controller->index();
    });

    // 2. Quản lý Danh mục
    $router->get('/danh-muc', function() { (new AdminCategoryController())->index(); });
    $router->post('/danh-muc/them', function() { (new AdminCategoryController())->store(); });
    $router->get('/danh-muc/sua/(\d+)', function($id) { (new AdminCategoryController())->edit($id); });
    $router->post('/danh-muc/sua/(\d+)', function($id) { (new AdminCategoryController())->update($id); });
    $router->get('/danh-muc/xoa/(\d+)', function($id) { (new AdminCategoryController())->delete($id); });

    // 3. Quản lý Nhà xuất bản (NXB)
    $router->get('/nha-xuat-ban', function() { (new AdminPublisherController())->index(); });
    $router->post('/nha-xuat-ban/them', function() { (new AdminPublisherController())->store(); });
    $router->get('/nha-xuat-ban/sua/(\d+)', function($id) { (new AdminPublisherController())->edit($id); });
    $router->post('/nha-xuat-ban/sua/(\d+)', function($id) { (new AdminPublisherController())->update($id); });
    $router->get('/nha-xuat-ban/xoa/(\d+)', function($id) { (new AdminPublisherController())->delete($id); });

    // 4. Quản lý Sản phẩm (Sách) & Biến thể
    $router->get('/sach', function() { (new AdminBookController())->index(); });
    $router->get('/sach/them', function() { (new AdminBookController())->create(); });
    $router->post('/sach/them', function() { (new AdminBookController())->store(); });
    $router->get('/sach/sua/(\d+)', function($id) { (new AdminBookController())->edit($id); });
    $router->post('/sach/sua/(\d+)', function($id) { (new AdminBookController())->update($id); });
    $router->get('/sach/xoa/(\d+)', function($id) { (new AdminBookController())->delete($id); });
    
    // Thêm và Xóa Biến thể (Đặc điểm SP)
    $router->post('/sach/bien-the/them', function() { (new AdminBookController())->addVariant(); });
    $router->get('/sach/bien-the/xoa/(\d+)/(\d+)', function($ma_dacdiem, $ma_sp) { (new AdminBookController())->deleteVariant($ma_dacdiem, $ma_sp); });

    // 5. Quản lý Đơn hàng
    $router->get('/don-hang', function() { (new AdminOrderController())->index(); });
    $router->get('/don-hang/chi-tiet/(\d+)', function($ma_dh) { (new AdminOrderController())->detail($ma_dh); });
    
    // Form Dropdown Cập nhật trạng thái
    $router->post('/don-hang/cap-nhat/(\d+)', function($ma_dh) { (new AdminOrderController())->updateStatus($ma_dh); });
    
    // Nút thao tác nhanh (Hủy / Xác nhận)
    $router->get('/don-hang/huy/(\d+)', function($ma_dh) { (new AdminOrderController())->cancel($ma_dh); });
    $router->get('/don-hang/xac-nhan/(\d+)', function($ma_dh) { (new AdminOrderController())->confirm($ma_dh); });

    // 6. Quản lý Khách hàng
    $router->get('/khach-hang', function() { (new AdminCustomerController())->index(); });
    $router->get('/khach-hang/khoa/(\d+)', function($id) { (new AdminCustomerController())->lock($id); });
    $router->get('/khach-hang/mo-khoa/(\d+)', function($id) { (new AdminCustomerController())->unlock($id); });

    // 7. Thông tin tài khoản Admin
    $router->get('/thong-tin', function() { (new AdminAccountController())->index(); });
    $router->post('/thong-tin/cap-nhat', function() { (new AdminAccountController())->update(); });
});
// ==========================================
// 4. TRANG LỖI 404
// ==========================================
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "<h1 style='text-align:center; padding-top: 50px; font-family: sans-serif;'>404 - Trang này không tồn tại!</h1>";
});

$router->run();
?>