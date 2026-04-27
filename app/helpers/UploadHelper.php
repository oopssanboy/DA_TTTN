<?php
class UploadHelper {
    
    /**
     * Xử lý upload hình ảnh
     * @param array $file Biến $_FILES['ten_the_input']
     * @param string $targetDir Thư mục đích (tính từ public/uploads/) VD: 'avatars/' hoặc 'books/'
     * @param array $allowTypes Các định dạng cho phép (Mặc định: ảnh)
     * @return array ['success' => boolean, 'path' => string, 'message' => string]
     */
    public static function uploadImage($file, $targetDir, $allowTypes = ['jpg', 'png', 'jpeg', 'gif', 'webp']) {
        // Kiểm tra xem có file tải lên và không có lỗi mốc sơ bộ
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'File không hợp lệ hoặc chưa được chọn.'];
        }

        // Tạo tên file duy nhất để không bị trùng (vd: 1689234_hinh.png)
        $fileName = time() . '_' . basename($file['name']);
        
        // Đường dẫn tuyệt đối để move_uploaded_file (ROOT_DIR trỏ tới thư mục gốc)
        $absoluteDirPath = ROOT_DIR . '/public/uploads/' . trim($targetDir, '/') . '/';
        $targetFilePath = $absoluteDirPath . $fileName;

        // Tự động tạo thư mục nếu chưa tồn tại
        if (!is_dir($absoluteDirPath)) {
            mkdir($absoluteDirPath, 0777, true);
        }

        // Lấy đuôi file và kiểm tra định dạng
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowTypes)) {
            return ['success' => false, 'message' => 'Chỉ hỗ trợ định dạng: ' . implode(', ', $allowTypes)];
        }

        // Thực hiện chuyển file
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // CHỈ TRẢ VỀ TÊN FILE (Ví dụ: 1777287111_DSC_0141.JPG)
            return ['success' => true, 'path' => $fileName];
        } else {
            return ['success' => false, 'message' => 'Lỗi khi di chuyển file vào thư mục máy chủ.'];
        }
    }
}
?>