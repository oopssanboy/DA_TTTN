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
                <h2 class="page-title" style="margin: 0; border: none; padding: 0;">
                    <?php echo isset($sp) ? 'Cập nhật sản phẩm #' . $sp['ma_sp'] : 'Thêm sản phẩm mới'; ?>
                </h2>
                <a href="/admin/sach" class="btn btn-xem"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            </div>

            <form action="<?php echo isset($sp) ? '/admin/sach/sua/' . $sp['ma_sp'] : '/admin/sach/them'; ?>" method="POST" enctype="multipart/form-data" class="account-form" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                
                <?php if(isset($sp)): ?>
                    <input type="hidden" name="hinh_anh_cu" value="<?php echo htmlspecialchars($sp['link_hinhanh']); ?>">
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div class="form-group">
                            <label>Tên sản phẩm <span style="color:red;">*</span></label>
                            <input type="text" name="tensp" value="<?php echo htmlspecialchars($sp['tensp'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Mô tả sản phẩm <span style="color:red;">*</span></label>
                            <textarea name="motasp" required style="height: 150px;"><?php echo htmlspecialchars($sp['motasp'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-group">
                            <label>Giá sản phẩm (VNĐ) <span style="color:red;">*</span></label>
                            <input type="number" name="giasp" value="<?php echo $sp['giasp'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Nhà xuất bản</label>
                            <select name="ma_nxb" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                <?php foreach($list_nxb as $nxb): ?>
                                    <option value="<?php echo $nxb['ma_nxb']; ?>" <?php echo (isset($sp) && $sp['ma_nxb'] == $nxb['ma_nxb']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($nxb['ten_nxb']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Danh mục</label>
                            <select name="ma_danhmuc" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                <?php foreach($list_dm as $dm): ?>
                                    <option value="<?php echo $dm['ma_danhmuc']; ?>" <?php echo (isset($sp) && $sp['ma_danhmuc'] == $dm['ma_danhmuc']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dm['ten_danhmuc']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Phân loại sách</label>
                            <select name="phan_loai" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                <option value="truyen" <?php echo (isset($sp) && $sp['phan_loai'] == 'truyen') ? 'selected' : ''; ?>>Truyện - Tiểu thuyết</option>
                                <option value="khampha" <?php echo (isset($sp) && $sp['phan_loai'] == 'khampha') ? 'selected' : ''; ?>>Sách Khám Phá</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Hình ảnh <?php echo isset($sp) ? '(Bỏ trống nếu không đổi)' : '<span style="color:red;">*</span>'; ?></label>
                            <input type="file" name="hinh_anh" accept="image/*" <?php echo isset($sp) ? '' : 'required'; ?> style="padding: 5px;">
                            <?php if(isset($sp) && !empty($sp['link_hinhanh'])): ?>
                                <img src="/uploads/books/<?php echo $sp['link_hinhanh']; ?>" style="width:80px; margin-top:10px; border:1px solid #ddd; border-radius:4px;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;"><i class="fa-solid fa-floppy-disk"></i> LƯU THÔNG TIN SẢN PHẨM</button>
            </form>

            <?php if(isset($sp)): ?>
                <hr style="margin: 40px 0; border: 0; border-top: 2px dashed #eee;">
                
                <h2 class="page-title" style="font-size: 18px; color: #d97706;">Quản Lý Biến Thể (Tồn Kho)</h2>
                
                <form action="/admin/sach/bien-the/them" method="POST" class="form-group-inline" style="background:#f9f9f9; padding:20px; border-radius:8px; border:1px solid #eee; margin-bottom:20px;">
                    <input type="hidden" name="ma_sp" value="<?php echo $sp['ma_sp']; ?>">
                    
                    <input type="text" name="chat_lieu" placeholder="Loại Bìa (VD: Bìa cứng)" required style="flex: 1;">
                    <input type="text" name="phien_ban" placeholder="Phiên bản (VD: Tiêu chuẩn)" required style="flex: 1;">
                    <input type="number" name="soluong_tonkho" placeholder="Số lượng" required style="width: 120px;">
                    
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm tồn kho</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Mã Biến thể</th>
                            <th>Chất liệu bìa</th>
                            <th>Phiên bản</th>
                            <th>Tồn kho</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($list_dacdiem_sp) && count($list_dacdiem_sp) > 0): ?>
                            <?php foreach ($list_dacdiem_sp as $v): ?>
                                <tr>
                                    <td><strong>#<?= $v['ma_dacdiem'] ?></strong></td>
                                    <td><?= htmlspecialchars($v['chat_lieu']) ?></td>
                                    <td><?= htmlspecialchars($v['phien_ban']) ?></td>
                                    <td><span class="badge <?= ($v['soluong_tonkho'] > 0) ? 'badge-success' : 'badge-danger' ?>"><?= $v['soluong_tonkho'] ?></span></td>
                                    <td>
                                        <a href="/admin/sach/bien-the/xoa/<?= $v['ma_dacdiem'] ?>/<?= $sp['ma_sp'] ?>" class="btn btn-xoa" onclick="confirmLink(event, 'Xóa biến thể này sẽ ảnh hưởng đến giỏ hàng của khách nếu đang chọn. Bạn chắc chứ?', this.href);"><i class="fa-solid fa-trash"></i> Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5">Sản phẩm này chưa có biến thể / tồn kho nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { document.querySelector('.admin-sidebar').classList.toggle('show'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
</script>