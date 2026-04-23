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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="page-title" style="margin: 0;">Lịch Sử Mua Hàng: <span style="color: var(--primary-color);"><?= htmlspecialchars($customer['ten_kh']) ?></span></h2>
                <a href="/admin/khach-hang" class="btn btn-xem"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            </div>

            <div class="user-info-box" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                <p style="margin: 5px 0;"><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
                <p style="margin: 5px 0;"><strong>Số điện thoại:</strong> <?= htmlspecialchars($customer['sdt'] ?? 'Chưa cập nhật') ?></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Thanh Toán</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders) && count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
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
                                        
                                        $badgeClass = '';
                                        $statusText = '';
                                        switch ($order['trangthai']) {
                                            case 'choxuly': $badgeClass = '#f39c12'; $statusText = 'Chờ xử lý'; break;
                                            case 'daxacnhan': $badgeClass = '#3498db'; $statusText = 'Đã xác nhận'; break;
                                            case 'hoanthanh': $badgeClass = '#2ecc71'; $statusText = 'Hoàn thành'; break;
                                            case 'huy': $badgeClass = '#e74c3c'; $statusText = 'Đã hủy'; break;
                                            default: $badgeClass = '#95a5a6'; $statusText = $order['trangthai'];
                                        }
                                    ?>
                                    <span style="background: <?= $badgeClass ?>; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/admin/don-hang/chi-tiet/<?= $order['ma_dh'] ?>" class="btn btn-sua"><i class="fa-solid fa-eye"></i> Xem Đơn</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; padding: 30px; color: #777;">Khách hàng này chưa có đơn hàng nào.</td></tr>
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