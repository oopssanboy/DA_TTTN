<?php
class Thongke extends DB {
    
    
    public function getOverview() {
        // Tổng doanh thu (Chỉ tính đơn đã hoàn thành)
        $sql_doanhthu = "SELECT SUM(tongtien) as total FROM orders WHERE trangthai = 'daxacnhan'";
        $tong_doanhthu = $this->select($sql_doanhthu)[0]['total'] ?? 0;

        // Tổng số đơn hàng
        $sql_donhang = "SELECT COUNT(*) as total FROM orders";
        $tong_donhang = $this->select($sql_donhang)[0]['total'] ?? 0;

        // Tổng số khách hàng (role = 0)
        $sql_khachhang = "SELECT COUNT(*) as total FROM users WHERE role = 0";
        $tong_khachhang = $this->select($sql_khachhang)[0]['total'] ?? 0;

        // Tổng số sách đang bán
        $sql_sach = "SELECT COUNT(*) as total FROM product";
        $tong_sach = $this->select($sql_sach)[0]['total'] ?? 0;

        return [
            'doanh_thu' => $tong_doanhthu,
            'don_hang' => $tong_donhang,
            'khach_hang' => $tong_khachhang,
            'sach' => $tong_sach
        ];
    }

    // 2. Lấy danh sách 5 đơn hàng mới nhất
    public function getRecentOrders($limit) {
        $sql = "SELECT * FROM orders ORDER BY ngay_dat DESC LIMIT " . (int)$limit;
        return $this->select($sql);
    }
}
?>