<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>
    
    <main class="container-main cart-page">
        <div class="breadcrumb">
            <a href="/" style="font-weight: 600;">Trang chủ</a> <span style="margin: 0 5px; ">/</span>
            <span class="current" style="font-weight: 600;">Giỏ hàng (<?php echo $sum_product; ?>)</span>
        </div>

        <?php if($list_cart == null): ?>
            <div class="empty-cart-box card-box text-center">
                <div class="empty-icon" style="font-size: 80px; color: #ddd; margin-bottom: 20px;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <h2 style="font-size: 22px; margin-bottom: 15px;">Giỏ hàng của bạn đang trống</h2>
                <p style="color: var(--text-muted); margin-bottom: 30px;">Hãy quay lại trang chủ và chọn cho mình những cuốn sách yêu thích nhé!</p>
                <a href="/" class="btn-primary" style="padding: 12px 30px; font-size: 16px;">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                
                <div class="cart-left-col">
                    <div class="card-box cart-items-container">
                        <div class="cart-items-header">
                            <h2 class="section-title-sm" style="margin:0; border:none; padding:0;">Sản phẩm trong giỏ</h2>
                        </div>

                        <?php foreach($list_cart as $cart): ?>
                            <div class="cart-item-row">
                                <div class="item-img">
                                    <a href="/san-pham/chi-tiet/<?php echo $cart['ma_sp']; ?>">
                                        <img src="<?= URLROOT ?>/uploads/books/<?php echo $cart['link_hinhanh']; ?>" alt="<?php echo $cart['tensp']; ?>">
                                    </a>
                                </div>
                                
                                <div class="item-info">
                                    <a href="/san-pham/chi-tiet/<?php echo $cart['ma_sp']; ?>" class="item-name"><?php echo $cart['tensp']; ?></a>
                                    <div class="item-variants">
                                        <span><strong>Phiên bản:</strong> <?php echo $cart['phien_ban']; ?></span>
                                        <span><strong>Chất liệu:</strong> <?php echo $cart['chat_lieu']; ?></span>
                                    </div>
                                    <div class="item-price-mobile">
                                        <?php echo number_format($cart['giasp']); ?> ₫
                                    </div>
                                </div>
                                
                                <div class="item-price">
                                    <span class="price-text"><?php echo number_format($cart['giasp']); ?> ₫</span>
                                </div>
                                
                                <div class="item-quantity">
                                    <div class="qty-control">
                                        <a href="/gio-hang/cap-nhat/<?php echo $cart['ma_cart']; ?>/decrease" class="qty-btn" style="text-decoration:none; display:flex; align-items:center; justify-content:center;">-</a>
                                        <input type="text" value="<?php echo $cart['soluong']; ?>" readonly>
                                        <a href="/gio-hang/cap-nhat/<?php echo $cart['ma_cart']; ?>/increase" class="qty-btn" style="text-decoration:none; display:flex; align-items:center; justify-content:center;">+</a>
                                    </div>
                                </div>
                                
                                <div class="item-action">
                                    <a href="/gio-hang/xoa/<?php echo $cart['ma_cart']; ?>" 
                                       onclick="confirmLink(event, 'Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?', this.href);" 
                                       class="btn-delete-item" title="Xóa">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cart-right-col">
                    <div class="card-box checkout-box">
                        <h2 class="section-title-sm" style="margin-bottom: 20px;">Thông tin đặt hàng</h2>
                        
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Tạm tính (<?php echo $sum_product; ?> sản phẩm):</span>
                                <strong><?php echo number_format($sum_money); ?> ₫</strong>
                            </div>
                            <div class="summary-row total">
                                <span>Tổng tiền:</span>
                                <span class="total-price"><?php echo number_format($sum_money); ?> ₫</span>
                            </div>
                            <p style="font-size: 12px; color: var(--text-muted); text-align: right; margin-top: 5px;">(Đã bao gồm VAT nếu có)</p>
                        </div>

                        <form action="/gio-hang/thanh-toan" method="POST" class="checkout-form" onsubmit="confirmForm(event, 'Xác nhận tiến hành đặt hàng với thông tin này?', this);">
                            
                            <h3>Thông tin giao hàng</h3>
                            
                            <div class="address-options">
                                <label>
                                    <input type="radio" name="address_option" value="default" checked onchange="toggleAddress(this.value)"> 
                                    Sử dụng thông tin tài khoản
                                </label>
                                <label>
                                    <input type="radio" name="address_option" value="new" onchange="toggleAddress(this.value)"> 
                                    Giao đến địa chỉ khác
                                </label>
                            </div>
                            <p>Họ tên:</p>
                            <input type="text" id="ship_ten_kh" name="ten_kh" placeholder="Nhập họ và tên" value="<?php echo $_SESSION['user_info']['ten_kh']; ?>" required>
                            <p>Số điện thoại:</p>
                            <input type="tel" id="ship_sdt" name="sdt" placeholder="Nhập số điện thoại" value="<?php echo $_SESSION['user_info']['sdt']; ?>" required><br>
                            <p>Email:</p>
                            <input type="email" id="ship_email" name="email" placeholder="Nhập email" value="<?php echo $_SESSION['user_info']['email']; ?>" required>
                            <p>Địa chỉ:</p>
                            <input type="text" id="ship_diachi" name="diachi" placeholder="Nhập địa chỉ" value="<?php echo $_SESSION['user_info']['dia_chi']; ?>" required><br>
                            
                            <h3 style="margin: 10px 0;">Ghi chú đơn hàng</h3>
                            <textarea name="ghichu"></textarea>
                            
                            <h3 style="margin: 10px 0;">Chọn phương thức thanh toán</h3>
                            <div class="payment-methods">
                                <label class="payment-item">
                                    <input type="radio" name="pttt" value="ttknh" checked>
                                    <img src="<?= URLROOT ?>/assets/user/img/ttknh.png" alt="COD">
                                    <span>Thanh toán khi nhận hàng (COD)</span>
                                </label>
                                <label class="payment-item">
                                    <input type="radio" name="pttt" value="bank">
                                    <img src="<?= URLROOT ?>/assets/user/img/thanhtoan_bank.png" alt="Bank">
                                    <span>Chuyển khoản ngân hàng</span>
                                </label>
                            </div>

                            <input type="hidden" name="tongtien" value="<?php echo $sum_money; ?>">
                            <input type="hidden" name="tongsp" value="<?php echo $sum_product; ?>">
                            <input type="hidden" name="ma_kh" value="<?php echo $_SESSION['user_info']['ma_kh']; ?>">
                            <input type="hidden" name="ngay_dat" value="<?php echo $date_now; ?>">
                            <input type="hidden" name="ngay_giaohang" value="<?php echo $date; ?>">

                            <button type="submit" class="btn-primary btn-checkout-submit">ĐẶT HÀNG NGAY</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include_once ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
    <script>
        const userInfo = {
            ten: "<?php echo $_SESSION['user_info']['ten_kh']; ?>",
            sdt: "<?php echo $_SESSION['user_info']['sdt']; ?>",
            email: "<?php echo $_SESSION['user_info']['email']; ?>",
            diachi: "<?php echo $_SESSION['user_info']['dia_chi']; ?>"
        };

        function toggleAddress(option) {
            const inputTen = document.getElementById('ship_ten_kh');
            const inputSdt = document.getElementById('ship_sdt');
            const inputEmail = document.getElementById('ship_email');
            const inputDiaChi = document.getElementById('ship_diachi');

            if (option === 'default') {
                inputTen.value = userInfo.ten;
                inputSdt.value = userInfo.sdt;
                inputEmail.value = userInfo.email;
                inputDiaChi.value = userInfo.diachi;
            } else if (option === 'new') {
                inputTen.value = '';
                inputSdt.value = '';
                inputEmail.value = '';
                inputDiaChi.value = '';
                inputTen.focus();
            }
        }
    </script>