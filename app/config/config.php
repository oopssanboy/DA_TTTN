<?php
// Tự động lấy URL gốc (Dùng cho CSS, JS, Link)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$scriptName = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
define('URLROOT', $protocol . "://" . $host . $scriptName);

// Đường dẫn thư mục (Dùng cho require/include)
define('APPROOT', dirname(dirname(__FILE__)));