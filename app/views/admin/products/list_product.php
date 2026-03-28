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
                <h2 class="page-title" style="margin: 0; border: none; padding: 0;">Quản Lý Sản Phẩm</h2>
                <a href="/admin/sach/them" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm sản phẩm mới</a>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Mã NXB</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($list_product) && count($list_product) > 0): ?>
                            <?php foreach ($list_product as $pro): ?>
                                <tr>
                                    <td><strong>#<?= $pro['ma_sp'] ?></strong></td>
                                    <td><img src="/uploads/books/<?= htmlspecialchars($pro['link_hinhanh']) ?>" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;"></td>
                                    <td style="text-align: left; max-width: 250px;"><strong><?= htmlspecialchars($pro['tensp']) ?></strong></td>
                                    <td style="color: var(--primary-color); font-weight: bold;"><?= number_format($pro['giasp']) ?> đ</td>
                                    <td><?= $pro['ma_nxb'] ?></td>
                                    <td> 
                                        <a href="/admin/sach/sua/<?= $pro['ma_sp'] ?>" class="btn btn-sua"><i class="fa-solid fa-pen"></i> Sửa / Biến thể</a> 
                                        <a href="/admin/sach/xoa/<?= $pro['ma_sp'] ?>" class="btn btn-xoa" onclick="confirmLink(event, 'Bạn có chắc chắn muốn xóa sản phẩm này?', this.href);"><i class="fa-solid fa-trash"></i> Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">Chưa có sản phẩm nào!</td></tr>
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