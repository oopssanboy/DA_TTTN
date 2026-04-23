<?php
class Review extends DB {
 
    public function getReviewsByProduct($ma_sp) {
        $sql = "SELECT r.*, u.ten_kh 
                FROM reviews r 
                JOIN users u ON r.ma_kh = u.ma_kh 
                WHERE r.ma_sp = ?
                ORDER BY r.ngay_bl DESC";
        return $this->select($sql, [$ma_sp]);
    }


    public function addReview($ma_sp, $ma_kh, $noidung, $sosao) {

        $ngay_bl = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO reviews (ma_sp, ma_kh, noidung, sosao, ngay_bl) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->insert($sql, [$ma_sp, $ma_kh, $noidung, $sosao, $ngay_bl]);
    }

    public function getAverageRating($ma_sp) {
        $sql = "SELECT AVG(sosao) as avg_star, COUNT(ma_review) as total_review 
                FROM reviews WHERE ma_sp = ?";
        $result = $this->select($sql, [$ma_sp]);
        return $result ? $result[0] : ['avg_star' => 0, 'total_review' => 0];
    }
    public function getAllReviewsForAdmin() {
        $sql = "SELECT r.*, u.ten_kh, s.tensp 
                FROM reviews r 
                JOIN users u ON r.ma_kh = u.ma_kh 
                JOIN product s ON r.ma_sp = s.ma_sp 
                ORDER BY r.ngay_bl DESC";
        return $this->select($sql);
    }

    public function deleteReview($ma_reviews) {
        $sql = "DELETE FROM reviews WHERE ma_review = ?";
        return $this->delete($sql, [$ma_reviews]); 
        
    }
}
?>