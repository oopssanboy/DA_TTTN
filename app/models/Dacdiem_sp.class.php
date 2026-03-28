<?php
class Dacdiem_sp extends DB{
    public function getAll(){
        $sql="select * from dacdiem_sp";
        return $this->select($sql);
    }
    public function getAll_groupby_chatlieu(){
        $sql="select * from dacdiem_sp group by chat_lieu";
        return $this->select($sql);
    }
    public function getAll_groupby_phien_ban(){
        $sql="select * from dacdiem_sp group by phien_ban";
        return $this->select($sql);
    }
    public function getByid($id)
    {
        $sql="select * from dacdiem_sp where ma_dacdiem = $id";
        return $this->select($sql);
    }
    
    public function getAll_byid_sp($id)
    {
        $sql="select * from dacdiem_sp where ma_sp = $id";
        return $this->select($sql);
    }
    public function add_dacdiem($ma_sp, $chat_lieu, $phien_ban, $soluong_tonkho) {
        $sql = "insert into dacdiem_sp (ma_sp, chat_lieu, phien_ban, soluong_tonkho) values (?, ?, ?, ?)";
        return $this->insert($sql, [$ma_sp, $chat_lieu, $phien_ban, $soluong_tonkho]);
    }
    public function delete_dacdiem($ma_dacdiem) {
        $sql = "delete from dacdiem_sp where ma_dacdiem = ?";
        return $this->delete($sql, [$ma_dacdiem]);
    }
    function update_tonkho($id, $chat_lieu,$phien_ban,$soluong,$mod){
        if($mod=='giam')
            $sql = "UPDATE dacdiem_sp SET soluong_tonkho = soluong_tonkho - " . $soluong . " where ma_sp = " . $id . " and chat_lieu = '" . $chat_lieu . "' and phien_ban = '" . $phien_ban . "'";
        else
            $sql = "UPDATE dacdiem_sp SET soluong_tonkho = soluong_tonkho + " . $soluong . " where ma_sp = " . $id . " and chat_lieu = '" . $chat_lieu . "' and phien_ban = '" . $phien_ban . "'";
        return $this->update($sql);
    }
}
?>