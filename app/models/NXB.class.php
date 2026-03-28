<?php
class NXB extends DB {
    public function getAll() {
        $sql = "SELECT * FROM nxb";
        return $this->select($sql); 
    }
    public function getByid_nxb($id)
    {
        $sql="select * from nxb where ma_nxb = $id";
        return $this->select($sql);
    }
    function update_nxb($id, $tennxb){
        $sql = "UPDATE nxb SET ten_nxb='".$tennxb."' WHERE ma_nxb=" .$id;
        return $this->update($sql);
    }

    function add_nxb ($tennxb) {
        $sql = "INSERT INTO nxb (ten_nxb) VALUES ('".$tennxb."')";
        return $this->insert($sql);
    }
    public function del_nxb($id) {
        $sql = "DELETE FROM nxb WHERE ma_nxb = " . (int)$id;
            return $this->delete($sql); 
    }
}
?>