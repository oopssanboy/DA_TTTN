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
            <h2 class="page-title">Quản Lý Khách Hàng</h2>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mã KH</th>
                            <th>Thông tin khách hàng</th>
                            <th>Liên hệ</th>
                            <th>Lịch sử mua hàng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($list_customers) && count($list_customers) > 0) {
                            foreach ($list_customers as $u) {
                    
                                $is_active = ($u['trangthai'] == 'hoatdong' || empty($u['trangthai']));
                                $badge_status = $is_active ? 'badge-success' : 'badge-danger';
                                $txt_status = $is_active ? 'Hoạt động' : 'Đã khóa';
                 
                                
                                if (isset($u['auth_provider']) && !empty($u['auth_provider'])) {
                                    if ($u['auth_provider'] == 'google') {
                                        $auth_type = '<i class="fa-brands fa-google" style="color:#db4437;"></i> Google';
                                    } elseif ($u['auth_provider'] == 'facebook') {
                                        $auth_type = '<i class="fa-brands fa-facebook" style="color:#1877f2;"></i> Facebook';
                                    }
                                }
                        ?>
                                <tr>
                                    <td><strong>#<?= $u['ma_kh'] ?></strong></td>
                                    <td style="text-align: left;">
                                        <strong><?= htmlspecialchars($u['ten_kh']) ?></strong><br>
                                        <span style="font-size:12px; color:var(--text-muted);"><?= htmlspecialchars($u['username'] ?? '') ?></span>
                                    </td>
                                    <td style="text-align: left;">
                                        <?= htmlspecialchars($u['email']) ?><br>
                                        <?= htmlspecialchars($u['sdt'] ?? '') ?>
                                    </td>
                                    <td><span class="badge" style="background:#f0f2f5;"><a href="/admin/khach-hang/lich-su/<?= $u['ma_kh'] ?>">Xem lịch sử</a></span></td>
                                    <td><span class="badge <?= $badge_status ?>"><?= $txt_status ?></span></td>
                                    <td>
                                        <?php if (!$is_active): ?>
                                            <a href="/admin/khach-hang/mo-khoa/<?= $u['ma_kh'] ?>" class="btn btn-sua" onclick="confirmLink(event, 'Bạn có chắc chắn muốn MỞ KHÓA tài khoản này?', this.href);"><i class="fa-solid fa-unlock"></i> Mở khóa</a>
                                        <?php else: ?>
                                            <a href="/admin/khach-hang/khoa/<?= $u['ma_kh'] ?>" class="btn btn-xoa" onclick="confirmLink(event, 'Bạn có chắc chắn muốn KHÓA tài khoản này? Khách hàng sẽ không thể đăng nhập.', this.href);"><i class="fa-solid fa-lock"></i> Khóa</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6'>Chưa có khách hàng nào trong hệ thống!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { document.querySelector('.admin-sidebar').classList.toggle('show'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
</script>