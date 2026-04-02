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
            <div class="account-header">
                <h2 class="page-title order-detail-title">Chi tiết đơn hàng #<?php echo $od['ma_dh']; ?></h2>
                <p>Ngày đặt: <?php echo $od['ngay_dat']; ?></p>
            </div>

            <h3 class="section-sub-title">Thông tin giao hàng</h3>
            <table style="margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($od['ten_kh']); ?></strong></td>
                        <td><?php echo htmlspecialchars($od['sdt']); ?></td>
                        <td><?php echo htmlspecialchars($od['email']); ?></td>
                        <td><?php echo htmlspecialchars($od['diachi_giaohang']); ?></td>
                        <td>
                            <?php 
                            if($od['phuongthuc_thanhtoan'] == "ttknh") {
                                echo "<span class='badge badge-success'><i class='fa-solid fa-money-bill'></i> Thanh toán khi nhận hàng</span>";
                            } else if($od['phuongthuc_thanhtoan'] == "bank"){
                                echo "<span class='badge' style='background:#e3f2fd; color:#1565c0;'><i class='fa-solid fa-building-columns'></i> Chuyển khoản ngân hàng</span>";
                            }else {
                                echo "<span class='badge row' style='background:#ecc9de; color:#1565c0;'><img src='https://upload.wikimedia.org/wikipedia/commons/a/a0/MoMo_Logo_App.svg' alt='MoMo' style='width: 20px; border-radius: 5px; margin-left: 35%'>&nbsp; MOMO</span>";
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h3 class="section-sub-title">Trạng thái đơn hàng</h3>
            <div class="status-update-box" style="margin-bottom: 30px;">
                <p style="margin-bottom: 15px;">Trạng thái hiện tại: 
                    <?php 
                        $badge = 'badge';
                        if($od['trangthai'] == 'daxacnhan' || $od['trangthai'] == 'dagiao') $badge = 'badge badge-success';
                        if($od['trangthai'] == 'huy') $badge = 'badge badge-danger';
                        echo "<span class='$badge' style='font-size: 14px; padding: 6px 12px;'>" . mb_strtoupper($od['trangthai'], 'UTF-8') . "</span>";
                    ?>
                </p>

                <?php if($od['trangthai'] != 'huy') { ?>
                    <form action="/admin/don-hang/cap-nhat/<?php echo $od['ma_dh']; ?>" method="POST" class="form-group-inline" style="align-items: center;" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                        <label class="status-label" style="margin-right: 15px;">Thay đổi trạng thái:</label>
                        <select name="trangthai" class="status-select" style="padding: 10px; border-radius: 4px; border: 1px solid #ccc; flex: 1; max-width: 300px;">
                            <option value="choxuly" <?php echo ($od['trangthai'] == 'choxuly') ? 'selected' : ''; ?>>Chờ xử lý</option>
                            <option value="daxacnhan" <?php echo ($od['trangthai'] == 'daxacnhan') ? 'selected' : ''; ?>>Đã xác nhận</option>
                            <option value="danggiao" <?php echo ($od['trangthai'] == 'danggiao') ? 'selected' : ''; ?>>Đang giao hàng</option>
                            <option value="dagiao" <?php echo ($od['trangthai'] == 'dagiao') ? 'selected' : ''; ?>>Đã giao hàng</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;"><i class="fa-solid fa-floppy-disk"></i> Lưu cập nhật</button>
                    </form>
                <?php } else { ?>
                    <p style="color: #d0011b; font-weight: bold;"><i class="fa-solid fa-circle-exclamation"></i> Đơn hàng này đã bị hủy, không thể thay đổi trạng thái.</p>
                <?php } ?>
            </div>

            <h3 class="section-sub-title">Chi tiết sản phẩm</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Phân loại</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($items)) {
                        foreach($items as $od_item) {
                            $thanh_tien = $od_item['giasp'] * $od_item['soluong'];
                            echo '<tr>
                                <td><img src="/uploads/books/' . htmlspecialchars($od_item['link_hinhanh']) . '" alt="Sản phẩm" class="product-img-sm"></td>
                                <td class="product-name-cell">' . htmlspecialchars($od_item['tensp']) . '</td>
                                <td>
                                    <span class="variant-info">Chất liệu: ' . htmlspecialchars($od_item['chat_lieu']) . '</span>
                                    <span class="variant-info">Phiên bản: ' . htmlspecialchars($od_item['phien_ban']) . '</span>
                                </td>
                                <td>' . number_format($od_item['giasp']) . ' đ</td>
                                <td><strong>x' . $od_item['soluong'] . '</strong></td>
                                <td class="price-highlight">' . number_format($thanh_tien) . ' đ</td>
                            </tr>';        
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có dữ liệu sản phẩm!</td></tr>";
                    }
                    ?>
                    <tr class="total-row" style="background-color: #fdfdfd;">
                        <td colspan="4" class="total-label" style="text-align: right; padding-right: 20px;"><strong>Tổng Tiền Phải Thu:</strong></td>
                        <td colspan="2" class="total-amount" >
                            <?php echo number_format($od['tongtien']); ?> đ
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="action-nav-group" style="margin-top: 30px; display: flex; gap: 10px;">
                <a href="/admin/don-hang" class="btn btn-xem btn-lg"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách</a> 
                
                <?php if($od['trangthai'] != 'huy') { ?>
                    <a href="/admin/don-hang/xac-nhan/<?php echo $od['ma_dh']; ?>" class="btn btn-primary btn-lg" onclick="confirmLink(event, 'Xác nhận đơn hàng này?', this.href);"><i class="fa-solid fa-check"></i> Xác nhận đơn hàng</a> 
                    <a href="/admin/don-hang/huy/<?php echo $od['ma_dh']; ?>" class="btn btn-xoa btn-lg" onclick="confirmLink(event, 'Bạn có chắc chắn muốn hủy đơn hàng này không? Tồn kho sẽ được cộng lại.', this.href);"><i class="fa-solid fa-xmark"></i> Hủy đơn hàng</a>
                <?php } ?>
            </div>

        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
<script>
    function toggleSidebar() { document.querySelector('.admin-sidebar').classList.toggle('show'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
</script>