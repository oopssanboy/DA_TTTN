<?php
class Controller {
    
    // Hàm gọi Model (Viết lại tường minh hơn)
    public function model($model) {
        $file_php = ROOT_DIR . '/app/models/' . $model . '.php';
        $file_class_php = ROOT_DIR . '/app/models/' . $model . '.class.php';

        // 1. Kiểm tra và nạp thẳng file để lộ ra lỗi thật (nếu có)
        if (file_exists($file_php)) {
            require_once $file_php;
        } elseif (file_exists($file_class_php)) {
            require_once $file_class_php;
        } else {
            // Lỗi 1: Đường dẫn thư mục bị sai
            die("<h3 style='color:red'>Lỗi chí mạng: Không tìm thấy file <b>{$model}.php</b> tại đường dẫn:<br> <i>{$file_php}</i></h3>");
        }

        // 2. Kiểm tra class sau khi nạp file
        if (class_exists($model)) {
            return new $model();
        } else {
            // Lỗi 2: Có file nhưng viết sai tên class
            die("<h3 style='color:red'>Lỗi chí mạng: Đã tìm thấy file, nhưng bên trong không có <b>class {$model}</b></h3>");
        }
    }

    // Hàm gọi View (Giữ nguyên của bạn)
    public function view($view, $data = []) {
        if(!empty($data)){
            extract($data);
        }

        $viewPath = ROOT_DIR . '/app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Lỗi: View [ {$view} ] không tồn tại tại đường dẫn: {$viewPath}");
        }
    }
}
?>