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
                <h2 class="page-title" style="margin: 0; border: none; padding: 0;">Quản Lý Mã Giảm Giá</h2>
                <a href="/admin/khuyen-mai/them" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mã mới</a>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mã Code</th>
                            <th>Loại Giảm</th>
                            <th>Giá Trị</th>
                            <th>Đơn Tối Thiểu</th>
                            <th>Lượt Dùng</th>
                            <th>Thời Hạn</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($list_coupons) && count($list_coupons) > 0): ?>
                            <?php foreach ($list_coupons as $cp): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($cp['code']) ?></strong></td>
                                    <td><?= ($cp['type'] == 'percent') ? 'Phần trăm (%)' : 'Tiền mặt' ?></td>
                                    <td style="color: var(--primary-color); font-weight: bold;">
                                        <?= number_format($cp['value']) ?><?= ($cp['type'] == 'percent') ? '%' : ' đ' ?>
                                    </td>
                                    <td><?= number_format($cp['min_order_value']) ?> đ</td>
                                    <td><span style="font-weight: 600;">0</span> / <?= $cp['usage_limit'] ?></td>
                                    <td style="font-size: 13px; color: #555;">
                                        Từ: <?= date('d/m/Y H:i', strtotime($cp['start_date'])) ?><br>
                                        Đến: <strong style="color: #d0011b;"><?= date('d/m/Y H:i', strtotime($cp['end_date'])) ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($cp['status'] == 1): ?>
                                            <span class="badge badge-success">Kích hoạt</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Đã khóa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/admin/khuyen-mai/sua/<?= $cp['id'] ?>" class="btn btn-sua" style="margin-bottom: 5px;"><i class="fa-solid fa-pen"></i> Sửa</a>
                                        <a href="/admin/khuyen-mai/xoa/<?= $cp['id'] ?>" class="btn btn-xoa" onclick="confirmLink(event, 'Bạn có chắc chắn muốn xóa mã <?= $cp['code'] ?> này?', this.href);"><i class="fa-solid fa-trash"></i> Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8">Chưa có mã khuyến mãi nào!</td></tr>
                        <?php endif; ?>
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