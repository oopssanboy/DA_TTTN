<?php
class Order extends DB{
    public function getAll(){
        $sql="select * from orders order by ma_dh desc";
        return $this->select($sql);
    }
    public function getByid($id)
    {
        $sql="select * from orders where ma_dh = $id";
        return $this->select($sql);
    }
     public function getAll_Byid_kh($ma_kh)
    {
        $sql="select * from orders where ma_kh = $ma_kh order by ma_dh desc";
        return $this->select($sql);
    }
    public function getAllcart_info_byid($id)
    {
        $sql="select * from cart join product on cart.ma_sp = product.ma_sp where cart.ma_kh = $id";
        return $this->select($sql);
    }
    public function add_order($ma_kh,$tongtien,$email,$tongsp,$trangthai,$phuongthuc_thanhtoan,$ngay_dat,$ngay_giaohang,$sdt,$ten_kh,$diachi_giaohang)
    {
        $sql="insert into orders(`ma_kh`, `tongtien`, `email`, `tongsp`, `trangthai`,`phuongthuc_thanhtoan`,`ngay_dat`,`ngay_giaohang`,`sdt`,`ten_kh`,`diachi_giaohang`) VALUES ('$ma_kh','$tongtien','$email','$tongsp','$trangthai','$phuongthuc_thanhtoan','$ngay_dat','$ngay_giaohang','$sdt','$ten_kh','$diachi_giaohang')";
        return $this->insert($sql);
    }
    public function del_order_client($ma_dh)
    {
        $sql="delete from orders WHERE ma_dh=$ma_dh and trangthai = 'choxuly'";
        return $this->delete($sql);
    }
    public function del_order_admin($ma_dh)
    {
        $sql="delete from orders WHERE ma_dh=$ma_dh";
        return $this->delete($sql);
    }
    function update_order($id, $trangthai){
        $sql = "UPDATE orders SET trangthai='".$trangthai."' WHERE ma_dh=" .$id;
        return $this->update($sql);
    }
}
?>