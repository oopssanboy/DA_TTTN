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
            <h2 class="page-title">Quản Lý Đơn Hàng</h2>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Số SP</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($list_orders) && count($list_orders) > 0) {
                            foreach ($list_orders as $od) {
                                $badge_class = 'badge';
                                if ($od['trangthai'] == 'daxacnhan' || $od['trangthai'] == 'dagiao')
                                    $badge_class = 'badge badge-success';
                                if ($od['trangthai'] == 'huy')
                                    $badge_class = 'badge badge-danger';

                                echo '<tr>
                                    <td><strong>#' . $od['ma_dh'] . '</strong></td>
                                    <td>' . htmlspecialchars($od['ten_kh']) . '</td>
                                    <td>' . $od['tongsp'] . '</td>
                                    <td style="color: var(--primary-color); font-weight: bold;">' . number_format($od['tongtien']) . ' đ</td>
                                    <td>' . $od['ngay_dat'] . '</td>
                                    <td><span class="' . $badge_class . '">' . htmlspecialchars($od['trangthai']) . '</span></td>
                                    <td> 
                                        <a href="/admin/don-hang/chi-tiet/' . $od['ma_dh'] . '" class="btn btn-xem">Chi tiết</a>';

                                // Nút Hủy (Không có icon)
                                if ($od['trangthai'] != 'huy' && $od['trangthai'] != 'dagiao') {
                                    echo ' <a href="/admin/don-hang/huy/' . $od['ma_dh'] . '" class="btn btn-xoa" onclick="confirmLink(event, \'Bạn có chắc chắn muốn hủy đơn hàng này không?\', this.href);">Hủy</a>';
                                }

                                echo '  </td>
                                        </tr>';
                            }
                        } else {
                            echo "<tr><td colspan='7'>Chưa có đơn hàng nào!</td></tr>";
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