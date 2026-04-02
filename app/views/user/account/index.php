<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>

<link rel="stylesheet" href="/assets/user/css/account.css">

<?php 
// Lấy avatar từ session, nếu không có thì dùng mặc định
$avatar = isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : '/images/logo_user.png';
?>

<main class="container-main account-page">
    <div class="account-layout row">
        
        <div class="account-sidebar">
            <div class="account-info-box card-box text-center">
                <div class="user-avatar-wrapper account-page-avatar">
                    <img src="<?php echo $avatar; ?>" alt="Avatar" class="user-avatar">
                </div>
                <h4 class="user-name-title"><?php echo $user_info['ten_kh']; ?></h4>
                <p class="user-role-label">Khách hàng</p>
            </div>
            
            <ul class="account-menu-list">
                <li><a href="/tai-khoan?tab=info" class="<?php echo ($tab == 'info') ? 'active' : ''; ?>"><i class="fa-solid fa-user"></i> Thông tin tài khoản</a></li>
                <li><a href="/tai-khoan?tab=change_info" class="<?php echo ($tab == 'change_info') ? 'active' : ''; ?>"><i class="fa-solid fa-pen-to-square"></i> Cập nhật thông tin</a></li>
                <li><a href="/tai-khoan?tab=xem_donhang" class="<?php echo ($tab == 'xem_donhang' || $tab == 'xem_chitiet') ? 'active' : ''; ?>"><i class="fa-solid fa-box-open"></i> Đơn hàng của bạn</a></li>
                <li><a href="/tai-khoan?tab=change_pass" class="<?php echo ($tab == 'change_pass') ? 'active' : ''; ?>"><i class="fa-solid fa-key"></i> Đổi mật khẩu</a></li>
                <li><a href="/dang-xuat" style="color: #d0011b;" onclick="confirmLink(event, 'Bạn có chắc chắn muốn đăng xuất?', this.href);"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
            </ul>
        </div>

        <div class="account-content">
            <div class="account-details-box card-box">
                
                <?php switch ($tab) {
                    
                    case 'change_info': ?>
                        <div class="account-header">
                            <h2 class="section-title">Chỉnh sửa thông tin tài khoản</h2>
                        </div>
                        <form action="/tai-khoan/cap-nhat-thong-tin" method="POST" class="account-form" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                            <div class="form-group row">
                                <label>Tên khách hàng</label>
                                <input type="text" name="ten_kh" value="<?php echo $user_info['ten_kh']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo $user_info['email']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label>Số điện thoại</label>
                                <input type="tel" name="sdt" value="<?php echo $user_info['sdt']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label>Địa chỉ</label>
                                <textarea name="dia_chi" required><?php echo $user_info['dia_chi']; ?></textarea>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="btn-primary">Lưu thay đổi</button>
                            </div>
                        </form>
                    <?php break;
                    
                    case 'xem_donhang': ?>
                        <div class="account-header">
                            <h2 class="section-title">Quản lý Đơn hàng</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="account-table">
                                <thead>
                                    <tr>
                                        <th>Mã ĐH</th><th>Tổng SP</th><th>Tổng tiền</th><th>Ngày đặt</th><th>Trạng thái</th><th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($list_order) && count($list_order) > 0) {
                                        foreach ($list_order as $oder) { ?>
                                            <tr>
                                                <td><strong>#<?php echo $oder['ma_dh']; ?></strong></td>
                                                <td><?php echo $oder['tongsp']; ?></td>
                                                <td style="color: var(--primary-color); font-weight: bold;"><?php echo number_format($oder['tongtien']); ?> đ</td>
                                                <td><?php echo $oder['ngay_dat']; ?></td>
                                                <td>
                                                    <?php if ($oder['trangthai'] == 'choxuly' || $oder['trangthai'] == 'daxacnhan') { ?>
                                                        <span class="status-badge status-success"><?php echo $oder['trangthai']; ?></span>
                                                    <?php } else if ($oder['trangthai'] == 'huy') { ?>
                                                        <span class="status-badge status-cancel"><?php echo $oder['trangthai']; ?></span>
                                                    <?php } else { ?>
                                                        <span class="status-badge"><?php echo $oder['trangthai']; ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td class="action-btns">
                                                    <a href="/tai-khoan?tab=xem_chitiet&ma_dh=<?php echo $oder['ma_dh']; ?>" class="btn-view">Xem</a>
                                                    <?php if ($oder['trangthai'] != 'huy' && $oder['trangthai'] != 'dagiao' && $oder['trangthai'] != 'daxacnhan') { ?>
                                                        <a href="/tai-khoan/huy-don/<?php echo $oder['ma_dh']; ?>" onclick="confirmLink(event, 'Hủy đơn hàng này?', this.href);" class="btn-cancel">Hủy</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo '<tr><td colspan="6" style="text-align:center;">Không có đơn hàng nào.</td></tr>';
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php break;

                    case 'xem_chitiet': ?>
                        <div class="account-header">
                            <h2 class="section-title">Chi tiết đơn hàng #<?php echo $ma_dh; ?></h2>
                        </div>
                        
                        <div class="order-info-card">
                            <h3>Thông tin giao hàng</h3>
                            <p><strong>Người nhận:</strong> <?php echo $order_info[0]['ten_kh']; ?></p>
                            <p><strong>Số điện thoại:</strong> <?php echo $order_info[0]['sdt']; ?></p>
                            <p><strong>Địa chỉ:</strong> <?php echo $order_info[0]['diachi_giaohang']; ?></p>
                        </div>

                        <div class="table-responsive" style="margin-top: 20px;">
                            <table class="account-table">
                                <thead>
                                    <tr><th>Sản phẩm</th><th>Chất liệu</th><th>Phiên bản</th><th>Giá</th><th>SL</th></tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items)) {
                                        foreach ($items as $item) { ?>
                                            <tr>
                                                <td style="display: flex; align-items: center; gap: 15px;">
                                                    <img src="/uploads/books/<?php echo $item['link_hinhanh']; ?>" style="width: 50px; border-radius: 4px;">
                                                    <span style="font-weight: 600;"><?php echo $item['tensp']; ?></span>
                                                </td>
                                                <td><?php echo $item['chat_lieu']; ?></td>
                                                <td><?php echo $item['phien_ban']; ?></td>
                                                <td style="color: var(--primary-color); font-weight: bold;"><?php echo number_format($item['giasp']); ?> đ</td>
                                                <td>x<?php echo $item['soluong']; ?></td>   
                                            </tr>
                                    <?php } } ?>
                                    <tr style="background-color: #fafafa;">
                                        <td colspan="3" style="text-align: right; font-weight: bold;">TỔNG TIỀN:</td>
                                        <td colspan="2" style="color: red; font-weight: bold; font-size: 18px; padding-left: 20px;">
                                            <?php echo number_format($order_info[0]['tongtien']); ?> đ
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 20px;">
                            <a href="/tai-khoan?tab=xem_donhang" class="btn-primary">Quay lại danh sách</a>
                        </div>
                    <?php break;

                    case 'change_pass': ?>
                        <div class="account-header">
                            <h2 class="section-title">Đổi mật khẩu</h2>
                        </div>
                        <form action="/tai-khoan/doi-mat-khau" method="POST" class="account-form" onsubmit="confirmForm(event, 'Xác nhận lưu thay đổi?', this);">
                            <div class="form-group row">
                                <label>Mật khẩu mới</label>
                                <input type="password" name="pass_new" required>
                            </div>
                            <div class="form-group row">
                                <label>Xác nhận</label>
                                <input type="password" name="pass_confirm" required>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="btn-primary">Đổi mật khẩu</button>
                            </div>
                        </form>
                    <?php break;

                    case 'info':
                    default: ?>
                        <div class="account-header">
                            <h2 class="section-title">Hồ sơ của tôi</h2>
                        </div>
                        <div class="profile-info-display">
                            <p><strong>Tên người dùng:</strong> <span><?php echo $user_info['ten_kh']; ?></span></p>
                            <p><strong>Email đăng nhập:</strong> <span><?php echo $user_info['email']; ?></span></p>
                            <p><strong>Số điện thoại:</strong> <span><?php echo $user_info['sdt']; ?></span></p>
                            <p><strong>Địa chỉ nhận hàng:</strong> <span><?php echo $user_info['dia_chi']; ?></span></p>
                            <br>
                            <a href="/tai-khoan?tab=change_info" class="btn-primary">Chỉnh sửa hồ sơ</a>
                        </div>
                    <?php break;
                } ?>
                
            </div>
        </div>

    </div>
</main>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>