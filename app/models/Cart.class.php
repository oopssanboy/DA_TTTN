<?php
class Cart extends DB{
    public function getAll(){
        $sql="select * from cart";
        return $this->select($sql);
    }
    public function getByid($id)
    {
        $sql="select * from cart where ma_cart = $id";
        return $this->select($sql);
    }
    public function getAllcart_info_byid($id)
    {
        $sql="select * from cart join product on cart.ma_sp = product.ma_sp where cart.ma_kh = $id";
        return $this->select($sql);
    }
    public function count_item_cart_byid($id)
    {
        $sql="select sum(soluong)as count from cart where cart.ma_kh = $id";
        return $this->select($sql);
    }
    public function add($ma_kh,$ma_sp,$chat_lieu,$phien_ban,$soluong)
    {
        $sql="insert into cart(`ma_kh`, `ma_sp`, `chat_lieu`, `phien_ban`, `soluong`) VALUES ('$ma_kh','$ma_sp','$chat_lieu','$phien_ban','$soluong')";
        return $this->insert($sql);
    }
    public function del_byid_kh($ma_kh)
    {
        $sql="delete from cart WHERE ma_kh=$ma_kh";
        return $this->delete($sql);
    }
    public function del($ma_cart)
    {
        $sql="delete from cart WHERE ma_cart=$ma_cart";
        return $this->delete($sql);
    }
    public function update_soluong($ma_cart, $soluong_moi)
    {
    $sql = "UPDATE cart SET soluong = '$soluong_moi' WHERE ma_cart = '$ma_cart'";
    return $this->update($sql);
    }
}
?>