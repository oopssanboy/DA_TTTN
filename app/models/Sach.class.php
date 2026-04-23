<?php
class Sach extends DB{
    public function getAll(){
        $sql="select * from product order by ma_sp desc";
        return $this->select($sql);
    }
    public function getAll_limit8($tab){
        if($tab === "sachhay"){
        // Thêm GROUP BY p.ma_sp để lấy danh sách từng cuốn sách
        $sql = "SELECT p.*, AVG(r.sosao) as sao_avg 
                FROM product p 
                LEFT JOIN reviews r ON r.ma_sp = p.ma_sp 
                GROUP BY p.ma_sp 
                ORDER BY sao_avg DESC LIMIT 8";
    } elseif($tab === "sachbanchay") {
        // Lấy sách dựa trên số lượng bán được trong bảng order_item
        $sql = "SELECT p.*, SUM(oi.soluong) as tong_ban 
                FROM product p 
                LEFT JOIN order_item oi ON p.ma_sp = oi.ma_sp 
                GROUP BY p.ma_sp 
                ORDER BY tong_ban DESC LIMIT 8";
    } else {
        $sql = "SELECT * FROM product ORDER BY ma_sp DESC LIMIT 8";
    }
        
        return $this->select($sql);
    }
    public function getByid($id)
    {
        $sql="select * from product where ma_sp = $id";
        return $this->select($sql);
    }
    public function getAll_bycartegory($ma_danhmuc){
        $sql="select * from product where ma_danhmuc=$ma_danhmuc";
        return $this->select($sql);
    }
    // Lấy tối đa 8 sản phẩm cùng danh mục (Loại trừ cuốn sách đang xem)
    public function getRelatedProducts($ma_danhmuc, $ma_sp_hien_tai, $limit) {
        $sql = "SELECT * FROM product 
                WHERE ma_danhmuc = ? AND ma_sp != ? 
                ORDER BY ma_sp DESC 
                LIMIT " . (int)$limit;
        return $this->select($sql, [$ma_danhmuc, $ma_sp_hien_tai]);
    }
    public function getAll_by_phanloai($phan_loai){
        $sql="select * from product where phan_loai = '" . $phan_loai . "'";
        return $this->select($sql);
    }
    public function getAll_dacdiem_byid($id)
    {
        $sql="select * from product join dacdiem_sp on product.ma_sp = dacdiem_sp.ma_sp where product.ma_sp = $id group by dacdiem_sp.chat_lieu order by chat_lieu asc";
        return $this->select($sql);
    }
    
    public function getAll_phanloai()
    {
        $sql="select * from product group by phan_loai";
        return $this->select($sql);
    }

    


    public function add_product($tensp, $motasp, $giasp, $ma_nxb, $link_hinhanh, $ma_danhmuc, $phan_loai) {
        $sql = "insert into product (tensp, motasp, giasp, ma_nxb, link_hinhanh, ma_danhmuc, phan_loai) 
                values (?, ?, ?, ?, ?, ?, ?)";
        return $this->insert($sql, [$tensp, $motasp, $giasp, $ma_nxb, $link_hinhanh, $ma_danhmuc, $phan_loai]);
    }
    public function delete_product($id) {
        $sql = "delete from product where ma_sp = ?";
        return $this->delete($sql, [$id]);
    }
    public function update_product($id, $tensp, $motasp, $giasp, $ma_nxb, $link_hinhanh, $ma_danhmuc, $phan_loai) {
        if ($link_hinhanh != '') {
            $sql = "update product set tensp=?, motasp=?, giasp=?, ma_nxb=?, link_hinhanh=?, ma_danhmuc=?, phan_loai=? where ma_sp=?";
            return $this->update($sql, [$tensp, $motasp, $giasp, $ma_nxb, $link_hinhanh, $ma_danhmuc, $phan_loai, $id]);
        } else {
            $sql = "update product set tensp=?, motasp=?, giasp=?, ma_nxb=?, ma_danhmuc=?, phan_loai=? where ma_sp=?";
            return $this->update($sql, [$tensp, $motasp, $giasp, $ma_nxb, $ma_danhmuc, $phan_loai, $id]);
        }
    }

    
    // public function loc_san_pham($ma_danhmuc, $phan_loai, $sap_xep, $nxb, $chat_lieu, $phien_ban, $keyword) {
    //     $sql = "SELECT DISTINCT p.* FROM product p  "; 
        
    //     if (!empty($chat_lieu) || !empty($phien_ban)) {
    //         $sql .= " JOIN dacdiem_sp d ON p.ma_sp = d.ma_sp ";
    //     }
        
    //     $sql .= " WHERE 1=1";
    //     $params = []; 
        
    //     if (!empty($ma_danhmuc)) {
    //         $sql .= " AND p.ma_danhmuc = ?"; 
    //         $params[] = $ma_danhmuc;
    //     }
        
    //     if (!empty($phan_loai)) {
    //         $sql .= " AND p.phan_loai = ?"; 
    //         $params[] = $phan_loai;
    //     }
        
    //     if (!empty($nxb)) {
    //         if (!is_array($nxb)) {
    //             $nxb = [$nxb]; 
    //         }
    //         $placeholders = implode(',', array_fill(0, count($nxb), '?'));
    //         $sql .= " AND p.ma_nxb IN ($placeholders)";
    //         foreach ($nxb as $id_hang) {
    //             $params[] = $id_hang;
    //         }
    //     }
    //     if (!empty($chat_lieu)) {
    //     $sql .= " AND d.chat_lieu LIKE ?"; 
    //     $params[] = "%" . $chat_lieu . "%";
    // }
    // if (!empty($phien_ban)) {
    //     $sql .= " AND d.phien_ban LIKE ?"; 
    //     $params[] = "%" . $phien_ban . "%";
    // }
    //     if (!empty($keyword)) {
    //             $sql .= " AND p.tensp LIKE ?"; 
    //             $params[] = "%" . $keyword . "%";
    //         }
            
             
    //     if ($sap_xep == 'gia_tang') {
    //         $sql .= " ORDER BY p.giasp ASC";
    //     } elseif ($sap_xep == 'gia_giam') {
    //         $sql .= " ORDER BY p.giasp DESC";
    //     } else {
    //         $sql .= " ORDER BY p.ma_sp DESC"; 
    //     }
        
    //     return $this->select($sql, $params);
    // }
    
    // 1. Đếm tổng số sản phẩm dựa trên các bộ lọc hiện tại
    // 1. Hàm đếm tổng số lượng
    public function count_loc_san_pham($ma_danhmuc, $phan_loai, $nxb, $chat_lieu, $phien_ban, $keyword, $sap_xep = '', $gia_min = 0, $gia_max = 0) {
        $sql = "SELECT COUNT(DISTINCT p.ma_sp) as total FROM product p ";
        
        if (!empty($chat_lieu) || !empty($phien_ban)) {
            $sql .= " JOIN dacdiem_sp d ON p.ma_sp = d.ma_sp ";
        }
        if ($sap_xep == 'ban_chay') {
            $sql .= " LEFT JOIN order_item oi ON p.ma_sp = oi.ma_sp ";
        }
        if ($sap_xep == 'danh_gia_cao') {
            $sql .= " LEFT JOIN reviews r ON p.ma_sp = r.ma_sp ";
        }

        $sql .= " WHERE 1=1";
        $params = [];
        
        if (!empty($ma_danhmuc)) { $sql .= " AND p.ma_danhmuc = ?"; $params[] = $ma_danhmuc; }
        if (!empty($phan_loai)) { $sql .= " AND p.phan_loai = ?"; $params[] = $phan_loai; }
        if (!empty($nxb)) {
            if (!is_array($nxb)) { $nxb = [$nxb]; }
            $placeholders = implode(',', array_fill(0, count($nxb), '?'));
            $sql .= " AND p.ma_nxb IN ($placeholders)";
            foreach ($nxb as $id_hang) { $params[] = $id_hang; }
        }
        if (!empty($chat_lieu)) { $sql .= " AND d.chat_lieu LIKE ?"; $params[] = "%" . $chat_lieu . "%"; }
        if (!empty($phien_ban)) { $sql .= " AND d.phien_ban LIKE ?"; $params[] = "%" . $phien_ban . "%"; }
        if (!empty($keyword)) { $sql .= " AND p.tensp LIKE ?"; $params[] = "%" . $keyword . "%"; }
        
        // LỌC THEO KHOẢNG GIÁ
        if ($gia_min > 0) { $sql .= " AND p.giasp >= ?"; $params[] = $gia_min; }
        if ($gia_max > 0) { $sql .= " AND p.giasp <= ?"; $params[] = $gia_max; }

        $result = $this->select($sql, $params);
        return $result[0]['total'] ?? 0;
    }

    // 2. Hàm lấy danh sách sản phẩm
    public function loc_san_pham($ma_danhmuc, $phan_loai, $sap_xep, $nxb, $chat_lieu, $phien_ban, $keyword, $limit = 12, $offset = 0, $gia_min = 0, $gia_max = 0) {
        $select_clause = "DISTINCT p.*";
        if ($sap_xep == 'danh_gia_cao') $select_clause .= ", AVG(r.sosao) as sao_avg";
        if ($sap_xep == 'ban_chay') $select_clause .= ", SUM(oi.soluong) as tong_ban";

        $sql = "SELECT $select_clause FROM product p ";
        
        if (!empty($chat_lieu) || !empty($phien_ban)) {
            $sql .= " JOIN dacdiem_sp d ON p.ma_sp = d.ma_sp ";
        }
        if ($sap_xep == 'ban_chay') {
            $sql .= " LEFT JOIN order_item oi ON p.ma_sp = oi.ma_sp ";
        }
        if ($sap_xep == 'danh_gia_cao') {
            $sql .= " LEFT JOIN reviews r ON p.ma_sp = r.ma_sp ";
        }

        $sql .= " WHERE 1=1";
        $params = [];
        
        if (!empty($ma_danhmuc)) { $sql .= " AND p.ma_danhmuc = ?"; $params[] = $ma_danhmuc; }
        if (!empty($phan_loai)) { $sql .= " AND p.phan_loai = ?"; $params[] = $phan_loai; }
        if (!empty($nxb)) {
            if (!is_array($nxb)) { $nxb = [$nxb]; }
            $placeholders = implode(',', array_fill(0, count($nxb), '?'));
            $sql .= " AND p.ma_nxb IN ($placeholders)";
            foreach ($nxb as $id_hang) { $params[] = $id_hang; }
        }
        if (!empty($chat_lieu)) { $sql .= " AND d.chat_lieu LIKE ?"; $params[] = "%" . $chat_lieu . "%"; }
        if (!empty($phien_ban)) { $sql .= " AND d.phien_ban LIKE ?"; $params[] = "%" . $phien_ban . "%"; }
        if (!empty($keyword)) { $sql .= " AND p.tensp LIKE ?"; $params[] = "%" . $keyword . "%"; }
        
        // LỌC THEO KHOẢNG GIÁ
        if ($gia_min > 0) { $sql .= " AND p.giasp >= ?"; $params[] = $gia_min; }
        if ($gia_max > 0) { $sql .= " AND p.giasp <= ?"; $params[] = $gia_max; }

        $sql .= " GROUP BY p.ma_sp ";

        // Sắp xếp
        if ($sap_xep == 'danh_gia_cao') { $sql .= " ORDER BY sao_avg DESC"; } 
        elseif ($sap_xep == 'ban_chay') { $sql .= " ORDER BY tong_ban DESC"; } 
        elseif ($sap_xep == 'gia_tang') { $sql .= " ORDER BY p.giasp ASC"; } 
        elseif ($sap_xep == 'gia_giam') { $sql .= " ORDER BY p.giasp DESC"; } 
        else { $sql .= " ORDER BY p.ma_sp DESC"; }

        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        
        return $this->select($sql, $params);
    }
}

?>