<?php
class AdminReviewController extends Controller {
    
    public function __construct() {

        if (!isset($_SESSION['admin_login'])) {
            header('Location: /dang-nhap');
            exit;
        }
    }

    public function index() {
        $reviewModel = $this->model('Review');
        $list_reviews = $reviewModel->getAllReviewsForAdmin();

        $data = [
            'title' => 'Quản lý Đánh giá - Admin',
            'reviews' => $list_reviews
        ];
        $this->view('admin/review/index', $data);
    }

    public function delete($id) {
        $reviewModel = $this->model('Review');
        
        if ($reviewModel->deleteReview($id)) {
            $_SESSION['flash_alert'] = ['title' => 'Thành công', 'text' => 'Đã xóa bình luận!', 'icon' => 'success'];
        } else {
            $_SESSION['flash_alert'] = ['title' => 'Lỗi', 'text' => 'Không thể xóa bình luận này.', 'icon' => 'error'];
        }
        
        header('Location: /admin/danh-gia');
        exit;
    }
}
?>