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
            <h2 class="page-title">Quản Lý Nhà Xuất Bản</h2>
            
            <?php
        
            if(isset($nxb_can_sua)) {
            ?>
                <form action="/admin/nha-xuat-ban/sua/<?php echo $nxb_can_sua['ma_nxb']; ?>" method="POST" class="form-group-inline" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                    <input type="text" name="ten_nxb" value="<?php echo htmlspecialchars($nxb_can_sua['ten_nxb']); ?>" required>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="/admin/nha-xuat-ban" class="btn btn-xoa">Hủy</a>
                </form>
            <?php 
            } else { 
            ?>
                <form action="/admin/nha-xuat-ban/them" method="POST" class="form-group-inline" onsubmit="confirmForm(event, 'Xác nhận thêm mới?', this);">
                    <input type="text" name="ten_nxb" placeholder="Nhập tên nhà xuất bản mới..." required>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</button>
                </form>
            <?php 
            } 
            ?>

            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã NXB</th>
                        <th>Tên Nhà Xuất Bản</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_nxb) && count($list_nxb) > 0): ?>
                        <?php $i = 1; foreach ($list_nxb as $nxb): ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><strong>#<?= $nxb['ma_nxb'] ?></strong></td>
                                <td><?= htmlspecialchars($nxb['ten_nxb']) ?></td>
                                <td>
                                    <a href="/admin/nha-xuat-ban/sua/<?= $nxb['ma_nxb'] ?>" class="btn btn-sua"><i class="fa-solid fa-pen"></i> Sửa</a> 
                                    <a href="/admin/nha-xuat-ban/xoa/<?= $nxb['ma_nxb'] ?>" class="btn btn-xoa" onclick="confirmLink(event, 'Xác nhận xóa Nhà xuất bản này?', this.href);"><i class="fa-solid fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Chưa có nhà xuất bản nào.</td></tr>
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