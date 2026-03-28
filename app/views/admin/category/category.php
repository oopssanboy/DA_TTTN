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
            <h2 class="page-title">Quản Lý Danh Mục</h2>
            
            <?php
            // KIỂM TRA TRẠNG THÁI "EDIT"
            if(isset($dm_can_sua)) {
            ?>
                <form action="/admin/danh-muc/sua/<?php echo $dm_can_sua['ma_danhmuc']; ?>" method="POST" class="form-group-inline" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                    <input type="text" name="ten_danhmuc" value="<?php echo htmlspecialchars($dm_can_sua['ten_danhmuc']); ?>" required>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="/admin/danh-muc" class="btn btn-xoa">Hủy</a>
                </form>
            <?php 
            } else { 
            ?>
                <form action="/admin/danh-muc/them" method="POST" class="form-group-inline" onsubmit="confirmForm(event, 'Thêm danh mục này?', this);">
                    <input type="text" name="ten_danhmuc" placeholder="Nhập tên danh mục mới..." required>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</button>
                </form>
            <?php 
            } 
            ?>
            
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã danh mục</th>
                        <th>Tên danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($list_dm) && count($list_dm) > 0) {
                            $i = 1;
                            foreach($list_dm as $dm){
                                echo '<tr>
                                        <td>' . $i . '</td>
                                        <td><strong>#' . $dm['ma_danhmuc'] . '</strong></td>
                                        <td>' . htmlspecialchars($dm['ten_danhmuc']) . '</td>
                                        <td> 
                                            <a href="/admin/danh-muc/sua/' . $dm['ma_danhmuc'] . '" class="btn btn-sua"><i class="fa-solid fa-pen"></i> Sửa</a> 
                                            <a href="/admin/danh-muc/xoa/' . $dm['ma_danhmuc'] . '" class="btn btn-xoa" onclick="confirmLink(event, \'Bạn có chắc chắn muốn xóa danh mục này?\', this.href);"><i class="fa-solid fa-trash"></i> Xóa</a>
                                        </td>
                                    </tr>';
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='4'>Chưa có danh mục nào!</td></tr>";
                        }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { document.querySelector('.admin-sidebar').classList.toggle('show'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
</script>