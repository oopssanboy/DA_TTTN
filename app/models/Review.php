<?php
class Review extends DB {
    
    // 1. Lấy tất cả bình luận của một sản phẩm (Kèm tên khách hàng)
    public function getReviewsByProduct($ma_sp) {
        $sql = "SELECT r.*, u.ten_kh 
                FROM reviews r 
                JOIN users u ON r.ma_kh = u.ma_kh 
                WHERE r.ma_sp = ? AND r.trangthai = 1
                ORDER BY r.ngay_bl DESC";
        return $this->select($sql, [$ma_sp]);
    }

    // 2. Thêm bình luận mới
    public function addReview($ma_sp, $ma_kh, $noidung, $sosao) {
        // Lấy ngày hiện tại
        $ngay_bl = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO reviews (ma_sp, ma_kh, noidung, sosao, ngay_bl) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->insert($sql, [$ma_sp, $ma_kh, $noidung, $sosao, $ngay_bl]);
    }
    
    // 3. Tính trung bình sao của sản phẩm
    public function getAverageRating($ma_sp) {
        $sql = "SELECT AVG(sosao) as avg_star, COUNT(ma_review) as total_review 
                FROM reviews WHERE ma_sp = ? AND trangthai = 1";
        $result = $this->select($sql, [$ma_sp]);
        return $result ? $result[0] : ['avg_star' => 0, 'total_review' => 0];
    }
}
?>