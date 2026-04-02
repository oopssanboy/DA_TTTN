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
        $reviewModel = $this->model('Review');
        $nxbModel = $this->model('NXB');

        // 2. Lấy thông tin sách & đặc điểm
        $product_detail = $sachModel->getByid($id);
        $product_info = $sachModel->getAll_dacdiem_byid($id);
        $list_reviews = $reviewModel->getReviewsByProduct($id);
        $rating_info = $reviewModel->getAverageRating($id);
        // Kiểm tra xem sách có tồn tại không
        if (count($product_detail) > 0) {
            $sp = $product_detail[0];
            $sp['nxb'] = $nxbModel->getByid_nxb($sp['ma_nxb'])[0]['ten_nxb'];
            // 3. Lấy thông tin danh mục của sách đó
            $category_detail = $catModel->getByid_dm($sp['ma_danhmuc']);
            $c = count($category_detail) > 0 ? $category_detail[0] : ['ten_danhmuc' => 'Danh mục không tồn tại'];
            
        } else {
            echo "<h2 style='text-align:center; margin-top:50px;'>Sản phẩm không tồn tại!</h2>";
            return;
        }

        // 4. Lấy danh sách sản phẩm liên quan (Ở đây lấy ngẫu nhiên/limit)
        $related_products = $sachModel->getAll_bycartegory($sp['ma_danhmuc']); 

        // 5. Chuẩn bị dữ liệu truyền ra View
        $data = [
            'title' => $sp['tensp'] . ' - Chapter One',
            'sp' => $sp,
            'c' => $c,
            'product_info' => $product_info,
            'related_products' => $related_products,
            'reviews' => $list_reviews,
            'rating_info' => $rating_info['avg_star']
        ];

        // 6. Gọi View
        $this->view('user/product/detail', $data);
    }
    // Hàm xử lý submit bình luận
    public function addComment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Yêu cầu đăng nhập mới được bình luận
            if (!isset($_SESSION['user_login'])) {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => 'Vui lòng đăng nhập để đánh giá!', 'icon' => 'warning'];
                header('Location: /dang-nhap');
                exit;
            }

            $ma_kh = $_SESSION['user_info']['ma_kh'];
            $ma_sp = $_POST['ma_sp'];
            $noidung = trim($_POST['noidung']);
            $sosao = isset($_POST['sosao']) ? (int)$_POST['sosao'] : 5; // Mặc định 5 sao nếu ko chọn

            if (empty($noidung)) {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => 'Nội dung bình luận không được để trống!', 'icon' => 'error'];
                header("Location: /san-pham/chi-tiet/$ma_sp");
                exit;
            }

            $reviewModel = $this->model('Review');
            $result = $reviewModel->addReview($ma_sp, $ma_kh, $noidung, $sosao);

            if ($result) {
                $_SESSION['flash_alert'] = ['title' => 'Thành công', 'text' => 'Cảm ơn bạn đã đánh giá sản phẩm!', 'icon' => 'success'];
            } else {
                $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => 'Không thể gửi bình luận lúc này.', 'icon' => 'error'];
            }

            header("Location: /san-pham/chi-tiet/$ma_sp");
            exit;
        }
    }
}
?>