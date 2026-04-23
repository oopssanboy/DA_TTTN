<?php

$current_uri = $_SERVER['REQUEST_URI'];

$admin_name = isset($_SESSION['user_info']['ten_kh']) ? $_SESSION['user_info']['ten_kh'] : (isset($_SESSION['admin_info']['username']) ? $_SESSION['admin_info']['username'] : 'Admin');
$admin_avatar = isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : '/assets/user/img/dora.png';
?>

<div class="admin-sidebar">
    <div class="admin-profile">
        <div class="avatar-wrapper">
            <img src="<?php echo $admin_avatar; ?>" alt="Admin">
        </div>
        <h4 class="admin-name"><?php echo $admin_name; ?></h4>
        <p class="admin-role">Quản trị viên</p>
    </div>
    
    <ul class="admin-menu">
        <li>
            <a href="/" target="_blank"><i class="fa-solid fa-store"></i> Xem trang Web</a>
        </li>
        
        <li>
            <a href="/admin" class="<?php echo ($current_uri == '/admin' || $current_uri == '/admin/') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie"></i> Thống kê
            </a>
        </li>
        
        <li>
            <a href="/admin/danh-muc" class="<?php echo (strpos($current_uri, '/admin/danh-muc') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-list"></i> Quản lý danh mục
            </a>
        </li>
        
        <li>
            <a href="/admin/nha-xuat-ban" class="<?php echo (strpos($current_uri, '/admin/nha-xuat-ban') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-building"></i> Quản lý nhà xuất bản
            </a>
        </li>
        
        <li>
            <a href="/admin/sach" class="<?php echo (strpos($current_uri, '/admin/sach') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-book"></i> Quản lý sản phẩm
            </a>
        </li>
        
        <li>
            <a href="/admin/don-hang" class="<?php echo (strpos($current_uri, '/admin/don-hang') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-box-open"></i> Quản lý đơn hàng
            </a>
        </li>
        
        <li>
            <a href="/admin/khach-hang" class="<?php echo (strpos($current_uri, '/admin/tai-khoan') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-users"></i> Quản lý khách hàng
            </a>
        </li>
        
        <li>
            <a href="/admin/khuyen-mai" class="<?php echo (strpos($current_uri, '/admin/khuyen-mai') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-ticket-simple"></i> Quản lý khuyến mãi
            </a>
        </li>

        <li>
            <a href="/admin/danh-gia" class="<?php echo (strpos($current_uri, '/admin/danh-gia') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-comments"></i> Quản lý đánh giá
            </a>
        </li>
        
        <li>
            <a href="/admin/thong-tin" class="<?php echo (strpos($current_uri, '/admin/thong-tin') !== false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-user-tie"></i> Quản lý tài khoản
            </a>
        </li>
        
        <li>
            <a href="/dang-xuat" style="color: #ff4d4f;" onclick="confirmLink(event, 'Bạn có chắc chắn muốn đăng xuất?', this.href);">
                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>