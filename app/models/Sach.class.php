<?php
class Sach extends DB{
    public function getAll(){
        $sql="select * from product order by ma_sp desc";
        return $this->select($sql);
    }
    public function getAll_limit8(){
        $sql="select * from product order by ma_sp desc limit 8";
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

    
    public function loc_san_pham($ma_danhmuc, $phan_loai, $sap_xep, $nxb, $chat_lieu, $phien_ban, $keyword) {
        $sql = "SELECT DISTINCT p.* FROM product p  "; 
        
        if (!empty($chat_lieu) || !empty($phien_ban)) {
            $sql .= " JOIN dacdiem_sp d ON p.ma_sp = d.ma_sp ";
        }
        
        $sql .= " WHERE 1=1";
        $params = []; 
        
        if (!empty($ma_danhmuc)) {
            $sql .= " AND p.ma_danhmuc = ?"; 
            $params[] = $ma_danhmuc;
        }
        
        if (!empty($phan_loai)) {
            $sql .= " AND p.phan_loai = ?"; 
            $params[] = $phan_loai;
        }
        
        if (!empty($nxb)) {
            if (!is_array($nxb)) {
                $nxb = [$nxb]; 
            }
            $placeholders = implode(',', array_fill(0, count($nxb), '?'));
            $sql .= " AND p.ma_nxb IN ($placeholders)";
            foreach ($nxb as $id_hang) {
                $params[] = $id_hang;
            }
        }
        if (!empty($chat_lieu)) {
        $sql .= " AND d.chat_lieu LIKE ?"; 
        $params[] = "%" . $chat_lieu . "%";
    }
    if (!empty($phien_ban)) {
        $sql .= " AND d.phien_ban LIKE ?"; 
        $params[] = "%" . $phien_ban . "%";
    }
        if (!empty($keyword)) {
                $sql .= " AND p.tensp LIKE ?"; 
                $params[] = "%" . $keyword . "%";
            }
            
             
        if ($sap_xep == 'gia_tang') {
            $sql .= " ORDER BY p.giasp ASC";
        } elseif ($sap_xep == 'gia_giam') {
            $sql .= " ORDER BY p.giasp DESC";
        } else {
            $sql .= " ORDER BY p.ma_sp DESC"; 
        }
        
        return $this->select($sql, $params);
    }
    
    
}

?>