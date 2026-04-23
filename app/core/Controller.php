<?php
class Controller {
    
 
    public function model($model) {
        $file_php = ROOT_DIR . '/app/models/' . $model . '.php';
        $file_class_php = ROOT_DIR . '/app/models/' . $model . '.class.php';

       
        if (file_exists($file_php)) {
            require_once $file_php;
        } elseif (file_exists($file_class_php)) {
            require_once $file_class_php;
        } else {
            
            die("<h3 style='color:red'> Không tìm thấy file <b>{$model}.php</b> tại đường dẫn:<br> <i>{$file_php}</i></h3>");
        }

      
        if (class_exists($model)) {
            return new $model();
        } else {
          
            die("<h3 style='color:red'> Đã tìm thấy file, nhưng bên trong không có <b>class {$model}</b></h3>");
        }
    }


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