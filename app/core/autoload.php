<?php
// Định nghĩa đường dẫn gốc của dự án (Lùi 2 cấp từ app/core/ -> thư mục gốc)
define('ROOT_DIR', dirname(dirname(__DIR__)));

// 1. Nạp file cấu hình (Bạn tự tạo file config.php chứa thông tin DB sau)
if (file_exists(ROOT_DIR . '/app/config/config.php')) {
    require_once ROOT_DIR . '/app/config/config.php';
}

// 2. Nạp Vendor (Composer) - Đường dẫn lúc này đã chuẩn xác
$composer_autoload = ROOT_DIR . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
} else {
    die("Lỗi: Không tìm thấy thư viện. Vui lòng chạy 'composer install'.");
}

// 3. Autoload các Class của bạn (Models, Controllers, Core)
spl_autoload_register(function ($class) {
    $directories = [
        ROOT_DIR . '/app/core/',
        ROOT_DIR . '/app/controllers/User/',    // Quét thư mục User Controller
        ROOT_DIR . '/app/controllers/Admin/',   // Quét thư mục Admin Controller
        ROOT_DIR . '/app/models/'
    ];

    foreach ($directories as $dir) {
        // Hỗ trợ cả đuôi .php và .class.php từ code cũ của bạn
        if (file_exists($dir . $class . '.php')) {
            require_once $dir . $class . '.php';
            return;
        }
        if (file_exists($dir . $class . '.class.php')) {
            require_once $dir . $class . '.class.php';
            return;
        }
    }
});
?>