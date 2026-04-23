<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>
<link rel="stylesheet" href="/assets/admin/css/admin.css">

<style>

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        border-left: 5px solid #d97706; 
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        font-size: 2.5rem;
        color: #d97706;
        margin-right: 20px;
        width: 60px;
        height: 60px;
        background: rgba(217, 119, 6, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-info h3 {
        margin: 0;
        font-size: 1.6rem;
        color: #333;
        font-weight: 800;
    }
    .stat-info p {
        margin: 5px 0 0;
        color: #777;
        font-size: 13px;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 1px;
    }
</style>

<div class="admin-wrapper">
    <?php require ROOT_DIR . '/app/views/admin/layouts/sidebar.php'; ?>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
        <div class="mobile-menu-toggle">
            <button class="btn-toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i> Menu</button>
        </div>

        <h2 class="page-title" style="margin-bottom: 20px;">Tổng Quan Hệ Thống</h2>

        <div class="stat-grid">
            <div class="stat-card" style="border-left-color: #e74c3c;">
                <div class="stat-icon" style="color: #e74c3c; background: rgba(231, 76, 60, 0.1);"><i class="fa-solid fa-sack-dollar"></i></div>
                <div class="stat-info">
                    <h3><?= number_format($overview['doanh_thu']) ?> ₫</h3>
                    <p>Tổng Doanh Thu</p>
                </div>
            </div>

            <a href="/admin/don-hang">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon" style="color: #3498db; background: rgba(52, 152, 219, 0.1);"><i class="fa-solid fa-cart-flatbed"></i></div>
                <div class="stat-info">
                    <h3><?= number_format($overview['don_hang']) ?></h3>
                    <p>Tổng Đơn Hàng</p>
                </div>
                
            </div>
            </a>
            
            <a href="/admin/khach-hang">
            <div class="stat-card" style="border-left-color: #2ecc71;">
                <div class="stat-icon" style="color: #2ecc71; background: rgba(46, 204, 113, 0.1);"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info">
                    <h3><?= number_format($overview['khach_hang']) ?></h3>
                    <p>Khách Hàng</p>
                </div>
            </div>
            </a>

            <a href="/admin/sach">
            <div class="stat-card" style="border-left-color: #9b59b6;">
                <div class="stat-icon" style="color: #9b59b6; background: rgba(155, 89, 182, 0.1);"><i class="fa-solid fa-book-open"></i></div>
                <div class="stat-info">
                    <h3><?= number_format($overview['sach']) ?></h3>
                    <p>Sách Đang Bán</p>
                </div>
            </div>
            </a>
        </div>

        <div class="card-box" style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 1.2rem; color: #333;"><i class="fa-solid fa-clock-rotate-left"></i> Đơn hàng mới nhất</h3>
                <a href="/admin/don-hang" style="color: var(--primary-color); text-decoration: none; font-size: 14px; font-weight: bold;">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_orders)): ?>
                        <?php foreach ($recent_orders as $order): ?>
                            <tr>
                                <td><strong>#<?= $order['ma_dh'] ?></strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['ngay_dat'])) ?></td>
                                <td style="color: #d97706; font-weight: bold;"><?= number_format($order['tongtien']) ?> ₫</td>
                                <td>
                                    <?php if ($order['phuongthuc_thanhtoan'] == 'momo'): ?>
                                        <span >MoMo</span>
                                    <?php elseif ($order['phuongthuc_thanhtoan'] == 'bank'): ?>
                                        <span >Chuyển khoản ngân hàng</span>
                                    <?php else: ?>
                                        <span>Thanh toán khi nhận hàng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                        $bg = ''; $st = '';
                                        switch ($order['trangthai']) {
                                            case 'choxuly': $bg = '#f39c12'; $st = 'Chờ xử lý'; break;
                                            case 'daxacnhan': $bg = '#3498db'; $st = 'Đã xác nhận'; break;
                                            case 'hoanthanh': $bg = '#2ecc71'; $st = 'Hoàn thành'; break;
                                            case 'huy': $bg = '#e74c3c'; $st = 'Đã hủy'; break;
                                        }
                                    ?>
                                    <span style="background: <?= $bg ?>; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        <?= $st ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/admin/don-hang/chi-tiet/<?= $order['ma_dh'] ?>" class="btn btn-sua"><i class="fa-solid fa-eye"></i> Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; padding: 20px;">Chưa có đơn hàng nào!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { document.querySelector('.admin-sidebar').classList.toggle('show'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
</script>