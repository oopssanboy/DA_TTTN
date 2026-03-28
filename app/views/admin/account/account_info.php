<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>
<link rel="stylesheet" href="/assets/admin/css/admin.css">

<div class="admin-wrapper">
    <?php require ROOT_DIR . '/app/views/admin/layouts/sidebar.php'; ?>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
        <div class="mobile-menu-toggle">
            <button class="btn-toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i> Menu</button>
        </div>

        <div class="card-box">
            
            <div class="account-header">
                <h2 class="page-title">Thông Tin Quản Trị Viên</h2>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            </div>
            
            <div class="profile-info-display" style="margin-bottom: 40px;">
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 25px;">
                    <img src="<?php echo isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : '/images/dora.png'; ?>" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-color);">
                    <div>
                        <h3 style="margin: 0 0 5px 0; color: var(--text-main); font-size: 22px;"><?php echo htmlspecialchars($admin_info['ten_kh'] ?? ''); ?></h3>
                        <span class="badge badge-success"><i class="fa-solid fa-shield-halved"></i> Quản trị viên cấp cao</span>
                    </div>
                </div>

                <p><strong><i class="fa-solid fa-envelope"></i> Email:</strong> <span><?php echo htmlspecialchars($admin_info['email'] ?? ''); ?></span></p>
                <p><strong><i class="fa-solid fa-phone"></i> Điện thoại:</strong> <span><?php echo htmlspecialchars($admin_info['sdt'] ?? 'Chưa cập nhật'); ?></span></p>
                <p><strong><i class="fa-solid fa-location-dot"></i> Địa chỉ:</strong> <span><?php echo htmlspecialchars($admin_info['dia_chi'] ?? 'Chưa cập nhật'); ?></span></p>
            </div>

            <div class="account-header">
                <h2 class="page-title">Chỉnh Sửa Hồ Sơ</h2>
            </div>
            
            <form action="/admin/thong-tin/cap-nhat" method="POST" class="account-form" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="ten_kh" value="<?php echo htmlspecialchars($admin_info['ten_kh'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email đăng nhập</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin_info['email'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Số điện thoại liên hệ</label>
                    <input type="tel" name="sdt" value="<?php echo htmlspecialchars($admin_info['sdt'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Địa chỉ hiện tại</label>
                    <textarea name="dia_chi" required><?php echo htmlspecialchars($admin_info['dia_chi'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> LƯU THAY ĐỔI
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { 
        document.querySelector('.admin-sidebar').classList.toggle('show'); 
        document.getElementById('sidebarOverlay').classList.toggle('show'); 
    }
</script>