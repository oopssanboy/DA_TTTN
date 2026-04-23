<?php
class User extends DB {

    public function getAll_User() {
      
        $sql = "SELECT * FROM users WHERE role = 0 ORDER BY ma_kh DESC";
        
       
        return $this->select($sql); 
    }
    public function get_user_byid($id) {
        if (empty($id) || !is_numeric($id)) {
            return null; 
        }
        $sql = "SELECT * FROM users WHERE ma_kh = ?";
        return $this->select($sql, [$id]);
    }

    
    public function checkLogin($email, $matkhau) {
        $sql = "SELECT * FROM users WHERE email = ? AND matkhau = ? LIMIT 1";
        $result = $this->select($sql, [$email, $matkhau]);
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    public function checkEmailExist($email) {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $result = $this->select($sql, [$email]);
        if (count($result) > 0) {
            return $result[0]; 
        }
        return false;
    }

    
    public function register($ten_kh, $email, $matkhau, $sdt, $dia_chi) {
        $sql = "INSERT INTO users (ten_kh, email, matkhau, sdt, dia_chi, role, avatar, token) 
                VALUES (?, ?, ?, ?, ?, 0, '', '')";
        return $this->insert($sql, [$ten_kh, $email, $matkhau, $sdt, $dia_chi]);
    }

    public function add_user_social($ten_kh, $email, $token, $avatar) {
        $matkhau_default = ''; 
        $sql = "INSERT INTO users (ten_kh, email, matkhau, token, avatar, role) 
                VALUES (?, ?, ?, ?, ?, 0)";
        return $this->insert($sql, [$ten_kh, $email, $matkhau_default, $token, $avatar]);
    }


    public function update_token($ma_kh, $new_token) {
        $sql = "UPDATE users SET token = ? WHERE ma_kh = ?";
        return $this->update($sql, [$new_token, $ma_kh]); 
    }


    public function update_password($matkhau, $ma_kh) {
        $sql = "UPDATE users SET matkhau = ? WHERE ma_kh = ?";
        return $this->update($sql, [$matkhau, $ma_kh]);
    }
    public function updatePasswordByEmail($email, $new_password) {
   
        $sql = "UPDATE users SET matkhau = ? WHERE email = ?";
        return $this->update($sql, [$new_password, $email]);
    }

 
    public function update_info($ten_kh, $email, $sdt, $dia_chi, $ma_kh) {
        $sql = "UPDATE users SET ten_kh = ?, email = ?, sdt = ?, dia_chi = ? WHERE ma_kh = ?";
        return $this->update($sql, [$ten_kh, $email, $sdt, $dia_chi, $ma_kh]);
    }
  
    public function update_avatar($avatar, $ma_kh) {
        $sql = "UPDATE users SET avatar = ? WHERE ma_kh = ?";
        return $this->update($sql, [$avatar, $ma_kh]);
    }
    public function update_trangthai($ma_kh, $trangthai) {
        $sql = "UPDATE users SET trangthai = ? WHERE ma_kh = ?";
        
      
        return $this->update($sql, [$trangthai, $ma_kh]); 
    }
}
?>