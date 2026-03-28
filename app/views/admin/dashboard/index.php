<?php 
// Vẫn gọi Header dùng chung của web (giống code cũ của bạn)
require ROOT_DIR . '/app/views/user/layouts/header.php'; 
?>

<link rel="stylesheet" href="/assets/admin/css/admin.css">

<div class="admin-wrapper">
    
    <?php require ROOT_DIR . '/app/views/admin/layouts/sidebar.php'; ?>
    
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
        
        <div class="mobile-menu-toggle">
            <button class="btn-toggle-sidebar" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i> Menu
            </button>
        </div>

        <div class="card-box">
            <h2 class="section-title" style="margin-bottom: 20px;">Thống kê tổng quan</h2>
            
            <div style="padding: 20px; background: #f9f9f9; border-radius: 8px; border: 1px dashed #ccc;">
                <p>Nội dung các biểu đồ, con số thống kê doanh thu, số đơn hàng... sẽ hiển thị ở đây.</p>
                <br>
                <p><i>(Tạm thời hiển thị khung mẫu để test Router)</i></p>
            </div>  
            
        </div>
    </div>
</div>

<?php 
// Gọi Footer dùng chung
require ROOT_DIR . '/app/views/user/layouts/footer.php'; 
?>

<script>
    function toggleSidebar() {
        var sidebar = document.querySelector('.admin-sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        if(sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    }
</script>