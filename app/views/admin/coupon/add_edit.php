<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>
<link rel="stylesheet" href="/assets/admin/css/admin.css">

<style>
    .form-group-custom label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
    }
</style>

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
                    <?php echo isset($cp) ? 'Cập nhật mã khuyến mãi: ' . $cp['code'] : 'Thêm mã khuyến mãi mới'; ?>
                </h2>
                <a href="/admin/khuyen-mai" class="btn btn-xem"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            </div>

            <form action="<?php echo isset($cp) ? '/admin/khuyen-mai/sua/' . $cp['id'] : '/admin/khuyen-mai/them'; ?>" method="POST" class="account-form" onsubmit="confirmForm(event, 'Xác nhận lưu thông tin mã khuyến mãi?', this);">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Mã Code (Nhập viết liền, không dấu) <span style="color:red;">*</span></label>
                            <input type="text" name="code" value="<?php echo $cp['code'] ?? ''; ?>" placeholder="VD: CHAPTER10" required style="text-transform: uppercase;">
                        </div>
                        
                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Loại giảm giá <span style="color:red;">*</span></label>
                            <select name="type" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                <option value="percent" <?php echo (isset($cp) && $cp['type'] == 'percent') ? 'selected' : ''; ?>>Giảm theo phần trăm (%)</option>
                                <option value="fixed" <?php echo (isset($cp) && $cp['type'] == 'fixed') ? 'selected' : ''; ?>>Giảm tiền mặt trực tiếp (VNĐ)</option>
                            </select>
                        </div>
                        
                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Giá trị giảm (Nhập số) <span style="color:red;">*</span></label>
                            <input type="number" name="value" value="<?php echo $cp['value'] ?? ''; ?>" placeholder="VD: 10 (cho 10%) hoặc 50000" required>
                        </div>

                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Mức giảm tối đa (VNĐ) <small style="color:#888;">(Chỉ áp dụng nếu giảm theo %)</small></label>
                            <input type="number" name="max_discount" value="<?php echo $cp['max_discount'] ?? '0'; ?>" required>
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Đơn hàng tối thiểu (VNĐ)</label>
                            <input type="number" name="min_order_value" value="<?php echo $cp['min_order_value'] ?? '0'; ?>" required>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div class="form-group-custom">
                                <label>Tổng lượt dùng <span style="color:red;">*</span></label>
                                <input type="number" name="usage_limit" value="<?php echo $cp['usage_limit'] ?? '100'; ?>" required>
                            </div>
                            <div class="form-group-custom">
                                <label>Lượt / 1 Khách <span style="color:red;">*</span></label>
                                <input type="number" name="usage_per_user" value="<?php echo $cp['usage_per_user'] ?? '1'; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Ngày bắt đầu <span style="color:red;">*</span></label>
                            <input type="datetime-local" name="start_date" value="<?php echo isset($cp) ? date('Y-m-d\TH:i', strtotime($cp['start_date'])) : ''; ?>" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                        </div>
                        
                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Ngày hết hạn <span style="color:red;">*</span></label>
                            <input type="datetime-local" name="end_date" value="<?php echo isset($cp) ? date('Y-m-d\TH:i', strtotime($cp['end_date'])) : ''; ?>" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                        </div>

                        <div class="form-group-custom" style="margin-bottom: 15px;">
                            <label>Trạng thái</label>
                            <select name="status" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                                <option value="1" <?php echo (isset($cp) && $cp['status'] == 1) ? 'selected' : ''; ?>>Kích hoạt</option>
                                <option value="0" <?php echo (isset($cp) && $cp['status'] == 0) ? 'selected' : ''; ?>>Tạm khóa</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: right; margin-top: 15px; border-top: 1px solid #eee; padding-top: 20px;">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa-solid fa-floppy-disk"></i> LƯU MÃ KHUYẾN MÃI</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { document.querySelector('.admin-sidebar').classList.toggle('show'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
</script>