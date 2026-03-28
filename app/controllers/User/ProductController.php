<?php
class ProductController extends Controller {
    
    public function detail($id) {
        // Kiểm tra ID hợp lệ
        if (empty($id) || !is_numeric($id)) {
            echo "<h2 style='text-align:center; margin-top:50px;'>ID Sản phẩm không hợp lệ!</h2>";
            return;
        }

        // 1. Gọi Models
        $sachModel = $this->model('Sach');
        $catModel = $this->model('Category');

        // 2. Lấy thông tin sách & đặc điểm
        $product_detail = $sachModel->getByid($id);
        $product_info = $sachModel->getAll_dacdiem_byid($id);

        // Kiểm tra xem sách có tồn tại không
        if (count($product_detail) > 0) {
            $sp = $product_detail[0];
            
            // 3. Lấy thông tin danh mục của sách đó
            $category_detail = $catModel->getByid_dm($sp['ma_danhmuc']);
            $c = count($category_detail) > 0 ? $category_detail[0] : ['ten_danhmuc' => 'Danh mục không tồn tại'];
            
        } else {
            echo "<h2 style='text-align:center; margin-top:50px;'>Sản phẩm không tồn tại!</h2>";
            return;
        }

        // 4. Lấy danh sách sản phẩm liên quan (Ở đây lấy ngẫu nhiên/limit)
        $related_products = $sachModel->getAll_limit8(); 

        // 5. Chuẩn bị dữ liệu truyền ra View
        $data = [
            'title' => $sp['tensp'] . ' - Chapter One',
            'sp' => $sp,
            'c' => $c,
            'product_info' => $product_info,
            'related_products' => $related_products
        ];

        // 6. Gọi View
        $this->view('user/product/detail', $data);
    }
}
?>