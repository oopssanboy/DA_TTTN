<?php
class Coupon extends DB {
    public function getAllCoupons() {
        $sql = "SELECT * FROM coupons ORDER BY id DESC";
        return $this->select($sql);
    }

    // 2. Lấy thông tin 1 mã theo ID
    public function getCouponById($id) {
        $sql = "SELECT * FROM coupons WHERE id = ?";
        $result = $this->select($sql, [$id]);
        return count($result) > 0 ? $result[0] : false;
    }
    public function getActiveCoupons() {
    $now = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM coupons 
            WHERE status = 1 
            AND end_date > ? 
            ORDER BY start_date DESC";
    return $this->select($sql, [$now]);
}
    // 3. Thêm mã giảm giá mới
    public function addCoupon($code, $type, $value, $min_order, $max_discount, $usage_limit, $usage_per_user, $start_date, $end_date, $status) {
        $sql = "INSERT INTO coupons (code, type, value, min_order_value, max_discount, usage_limit, usage_per_user, start_date, end_date, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->insert($sql, [$code, $type, $value, $min_order, $max_discount, $usage_limit, $usage_per_user, $start_date, $end_date, $status]);
    }

    // 4. Cập nhật mã giảm giá
    public function updateCoupon($id, $code, $type, $value, $min_order, $max_discount, $usage_limit, $usage_per_user, $start_date, $end_date, $status) {
        $sql = "UPDATE coupons SET code = ?, type = ?, value = ?, min_order_value = ?, max_discount = ?, usage_limit = ?, usage_per_user = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?";
        return $this->update($sql, [$code, $type, $value, $min_order, $max_discount, $usage_limit, $usage_per_user, $start_date, $end_date, $status, $id]);
    }

    // 5. Xóa mã giảm giá
    public function deleteCoupon($id) {
        $sql = "DELETE FROM coupons WHERE id = ?";
        return $this->delete($sql, [$id]);
    }
    public function checkValidCoupon($code, $user_id, $tongtien_donhang) {
        // 1. Kiểm tra mã tồn tại và đang hoạt động
        $sql = "SELECT * FROM coupons WHERE code = ? AND status = 1 LIMIT 1";
        $result = $this->select($sql, [$code]);
        if (empty($result)) return ['success' => false, 'msg' => 'Mã không tồn tại hoặc đã bị khóa!'];
        
        $coupon = $result[0];
        $now = date('Y-m-d H:i:s');
        
        // 2. Kiểm tra thời hạn sử dụng
        if ($now < $coupon['start_date']) return ['success' => false, 'msg' => 'Mã chưa đến thời gian áp dụng.'];
        if ($now > $coupon['end_date']) return ['success' => false, 'msg' => 'Mã đã hết hạn sử dụng.'];
        
        // 3. Kiểm tra giá trị đơn hàng tối thiểu
        if ($tongtien_donhang < $coupon['min_order_value']) {
            return ['success' => false, 'msg' => 'Đơn hàng chưa đạt mức ' . number_format($coupon['min_order_value']) . 'đ'];
        }
        
        // 4. Kiểm tra tổng lượt dùng còn lại
        $sql_total = "SELECT COUNT(*) as total FROM coupon_usages WHERE coupon_id = ?";
        $total_res = $this->select($sql_total, [$coupon['id']]);
        if ($total_res[0]['total'] >= $coupon['usage_limit']) return ['success' => false, 'msg' => 'Mã đã hết lượt dùng.'];
        
        // 5. Kiểm tra giới hạn dùng của từng User
        $sql_user = "SELECT COUNT(*) as user_total FROM coupon_usages WHERE coupon_id = ? AND user_id = ?";
        $user_res = $this->select($sql_user, [$coupon['id'], $user_id]);
        if ($user_res[0]['user_total'] >= $coupon['usage_per_user']) return ['success' => false, 'msg' => 'Bạn đã hết lượt dùng mã này.'];
        
        // 6. Tính toán số tiền giảm
        $discount = ($coupon['type'] == 'percent') ? ($tongtien_donhang * $coupon['value'] / 100) : $coupon['value'];
        if ($coupon['max_discount'] > 0 && $discount > $coupon['max_discount']) $discount = $coupon['max_discount'];
        if ($discount > $tongtien_donhang) $discount = $tongtien_donhang;

        return ['success' => true, 'coupon' => $coupon, 'discount' => round($discount)];
    }

    public function markUsed($user_id, $coupon_id, $order_id) {
        $sql = "INSERT INTO coupon_usages (user_id, coupon_id, order_id) VALUES (?, ?, ?)";
        return $this->insert($sql, [$user_id, $coupon_id, $order_id]);
    }
}