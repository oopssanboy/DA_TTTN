<?php
class Order_item extends DB{
    public function getAll(){
        $sql="select * from order_item";
        return $this->select($sql);
    }
    public function add_order_item($ma_sp,$ma_dh,$chat_lieu,$soluong,$giasp,$phien_ban)
    {
        $sql="insert into order_item(`ma_sp`, `ma_dh`, `chat_lieu`, `soluong`, `giasp`,`phien_ban`) VALUES ('$ma_sp','$ma_dh','$chat_lieu','$soluong','$giasp','$phien_ban')";
        return $this->insert($sql);
    }
    public function del_order_item($ma_dh)
    {
        $sql="delete from order_item WHERE ma_dh=$ma_dh";
        return $this->delete($sql);
    }
    public function getAll_orderitem_byid_dh($id)
    {
        $sql="select * from order_item where order_item.ma_dh = $id";
        return $this->select($sql);
    }
    public function getAll_orderitem_info_byid($id)
    {
        $sql="select * from order_item join product on order_item.ma_sp = product.ma_sp where order_item.ma_dh = $id";
        return $this->select($sql);
    }
}
?>