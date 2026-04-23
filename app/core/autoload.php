<?php

define('ROOT_DIR', dirname(dirname(__DIR__)));

if (file_exists(ROOT_DIR . '/app/config/config.php')) {
    require_once ROOT_DIR . '/app/config/config.php';
}

$composer_autoload = ROOT_DIR . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
} else {
    die("Lỗi: Không tìm thấy thư viện. Vui lòng chạy 'composer install'.");
}

spl_autoload_register(function ($class) {
    $directories = [
        ROOT_DIR . '/app/core/',
        ROOT_DIR . '/app/controllers/User/',   
        ROOT_DIR . '/app/controllers/Admin/',  
        ROOT_DIR . '/app/models/'
    ];

    foreach ($directories as $dir) {
      
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