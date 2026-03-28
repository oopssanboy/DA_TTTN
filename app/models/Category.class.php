<?php
class Category extends DB{
    public function getAll_dm(){
        $sql="select * from category";
        return $this->select($sql);
    }
    public function getByid_dm($id)
    {
        $sql="select * from category where ma_danhmuc = $id";
        return $this->select($sql);
    }
    function del_dm($id) {
        $sql_check = "SELECT * FROM product WHERE ma_danhmuc=" . $id;
        $result_check = $this->select($sql_check);

        if ($result_check && count($result_check) > 0) {
            return "Cảnh báo: Danh mục này đang chứa sản phẩm, không thể xóa!";
        }
        try {
            $sql = "DELETE FROM category WHERE ma_danhmuc=" . $id;
            
             return $this->delete($sql);
        } catch (mysqli_sql_exception $e) {
            return "Lỗi dữ liệu: Danh mục này đang liên kết với bảng khác (Sản phẩm/Đơn hàng).";
        }
        return "Lỗi không xác định.";
    }
    function update_dm($id, $tendm){
        $sql = "UPDATE category SET ten_danhmuc='".$tendm."' WHERE ma_danhmuc=" .$id;
        return $this->update($sql);
    }

    function add_dm ($tendm) {
        $sql = "INSERT INTO category (ten_danhmuc) VALUES ('".$tendm."')";
        return $this->insert($sql);
    }
}
?>

