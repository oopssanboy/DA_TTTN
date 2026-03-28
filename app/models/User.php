<?php
class User extends DB {

    public function getAll_User() {
        // Lấy danh sách khách hàng và sắp xếp người mới đăng ký lên đầu
        $sql = "SELECT * FROM users WHERE role = 0 ORDER BY ma_kh DESC";
        
        // Gọi hàm select/query từ class DB của bạn (Tùy theo class DB bạn viết mà sửa lại cho đúng nhé)
        return $this->select($sql); 
    }
    public function get_user_byid($id) {
        if (empty($id) || !is_numeric($id)) {
            return null; 
        }
        $sql = "SELECT * FROM users WHERE ma_kh = ?";
        return $this->select($sql, [$id]);
    }

    // ĐĂNG NHẬP TRUYỀN THỐNG
    public function checkLogin($email, $matkhau) {
        $sql = "SELECT * FROM users WHERE email = ? AND matkhau = ? LIMIT 1";
        $result = $this->select($sql, [$email, $matkhau]);
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    // Kiểm tra email tồn tại (Dùng chung cho Đăng ký & Social Login)
    public function checkEmailExist($email) {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $result = $this->select($sql, [$email]);
        if (count($result) > 0) {
            return $result[0]; 
        }
        return false;
    }

    // ĐĂNG KÝ TRUYỀN THỐNG (Mặc định role = 0)
    public function register($ten_kh, $email, $matkhau, $sdt, $dia_chi) {
        $sql = "INSERT INTO users (ten_kh, email, matkhau, sdt, dia_chi, role, avatar, token) 
                VALUES (?, ?, ?, ?, ?, 0, '', '')";
        return $this->insert($sql, [$ten_kh, $email, $matkhau, $sdt, $dia_chi]);
    }

    // TẠO TÀI KHOẢN TỪ GOOGLE / FACEBOOK
    public function add_user_social($ten_kh, $email, $token, $avatar) {
        $matkhau_default = ''; 
        $sql = "INSERT INTO users (ten_kh, email, matkhau, token, avatar, role) 
                VALUES (?, ?, ?, ?, ?, 0)";
        return $this->insert($sql, [$ten_kh, $email, $matkhau_default, $token, $avatar]);
    }

    // Cập nhật Token mạng xã hội
    public function update_token($ma_kh, $new_token) {
        $sql = "UPDATE users SET token = ? WHERE ma_kh = ?";
        return $this->update($sql, [$new_token, $ma_kh]); 
    }

    // Cập nhật Mật khẩu
    public function update_password($matkhau, $ma_kh) {
        $sql = "UPDATE users SET matkhau = ? WHERE ma_kh = ?";
        return $this->update($sql, [$matkhau, $ma_kh]);
    }

    // Cập nhật Thông tin cá nhân
    public function update_info($ten_kh, $email, $sdt, $dia_chi, $ma_kh) {
        $sql = "UPDATE users SET ten_kh = ?, email = ?, sdt = ?, dia_chi = ? WHERE ma_kh = ?";
        return $this->update($sql, [$ten_kh, $email, $sdt, $dia_chi, $ma_kh]);
    }
    
    // Cập nhật Avatar
    public function update_avatar($avatar, $ma_kh) {
        $sql = "UPDATE users SET avatar = ? WHERE ma_kh = ?";
        return $this->update($sql, [$avatar, $ma_kh]);
    }
    public function update_trangthai($ma_kh, $trangthai) {
        $sql = "UPDATE users SET trangthai = ? WHERE ma_kh = ?";
        
        // Gọi hàm execute/query từ class DB của bạn
        return $this->update($sql, [$trangthai, $ma_kh]); 
    }
}
?>