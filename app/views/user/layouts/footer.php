<footer class="site-footer">
    <div class="footer-main">
        <div class="footer-col brand-info">
            <h3>CHAPTER ONE</h3>
            <p>Chuyên cung cấp các thể loại sách nổi tiếng, giúp bạn nâng tầm tri thức và dẫn đầu xu hướng.</p>
            <ul class="contact-list">
                <li><img src="/assets/user/img/icons_address.png" alt="Địa chỉ"> 180 Cao Lỗ, Phường 4, Quận 8, TP.HCM</li>
                <li><img src="/assets/user/img/icons_call.png" alt="Điện thoại"> 0964789010</li>
                <li><img src="/assets/user/img/icons_email.png" alt="Email"> dh52201285@student.stu.edu.vn</li>
            </ul>
            <div class="bct-logo">
                <img src="/assets/user/img/logo_bo_cong_thuong.png" alt="Bộ Công Thương">
                <span class="bct-text">Bộ Công Thương</span>
            </div>
        </div>

        <div class="footer-col quick-links">
            <h3>LIÊN KẾT NHANH</h3>
            <ul>
                <li><a href="/">Trang chủ</a></li>
                <li><a href="/gioi-thieu">Giới thiệu</a></li>
                <li><a href="/san-pham">Sản phẩm</a></li>
                <li><a href="#">Tin tức</a></li>
                <li><a href="/lien-he">Liên hệ</a></li>
                <li><a href="#">Tuyển dụng</a></li>
            </ul>
        </div>

        <div class="footer-col footer-map">
            <h3>BẢN ĐỒ</h3>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3920.0235231145187!2d106.6776813142867!3d10.739499992345688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fad027e3727%3A0x2a77b414e887f86d!2zMTgwIENhbyBM4buXLCBQaMaw4budbmcgNCwgUXXhuq1uIDgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1680000000000!5m2!1svi!2s" width="100%" height="160" style="border:0; border-radius: 6px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <div class="copyright">
                © 2025 Copyright Cửa Hàng Sách Chapter One - The Beginning. All rights reserved.
            </div>
            <div class="social-links">
                <a href="#"><img src="/assets/user/img/logo_shoppe.png" alt="Shopee"></a>
                <a href="#"><img src="/assets/user/img/logo_insta.png" alt="Instagram"></a>
                <a href="https://www.tiktok.com/@oopssanboy"><img src="/assets/user/img/logo_tiktok.png" alt="TikTok"></a>
            </div>
        </div>
    </div>
</footer>

<div id="globalCustomModal" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <div class="custom-modal-icon" id="globalModalIcon">
            <i class="fa-solid fa-circle-question"></i>
        </div>
        <h3 id="globalModalTitle">Xác nhận</h3>
        <p id="globalModalMessage">Bạn có chắc chắn không?</p>
        <div class="custom-modal-actions">
            <button id="globalModalCancel" class="btn-cancel-modal">Hủy</button>
            <button id="globalModalConfirm" class="btn-primary">Đồng ý</button>
        </div>
    </div>
</div>

<?php
    // Lấy đường dẫn request thực tế do Router điều khiển
    $current_url = $_SERVER['REQUEST_URI'];
    $show_floating_buttons = true;

    // Thay đổi logic kiểm tra URL (dùng router links)
    if (strpos($current_url, '/admin') !== false || 
        strpos($current_url, '/dang-nhap') !== false || 
        strpos($current_url, '/dang-ky') !== false || 
        strpos($current_url, '/tai-khoan') !== false) {
        $show_floating_buttons = false;
    }

    if ($show_floating_buttons) {
?>
    <div class="floating-contact">
        <a href="https://zalo.me/0964789014" target="_blank" class="contact-btn zalo-btn" title="Chat Zalo">
            <span>Zalo</span>
        </a>
        
        <a href="https://m.me/100573244885297" target="_blank" class="contact-btn mess-btn" title="Chat Messenger">
            <i class="fa-brands fa-facebook-messenger"></i>
        </a>
        
        <a href="tel:0964789014" class="contact-btn phone-btn" title="Gọi Hotline">
            <i class="fa-solid fa-phone-volume"></i>
        </a>
    </div>
<?php 
    } 
?>

<script>
    // ----- LOGIC ĐIỀU KHIỂN HỘP THOẠI -----
    let currentConfirmCallback = null;

    function showGlobalModal(message, type = 'confirm', confirmCallback = null, title = null) {
        const overlay = document.getElementById('globalCustomModal');
        const titleEl = document.getElementById('globalModalTitle');
        const msgEl = document.getElementById('globalModalMessage');
        const iconEl = document.getElementById('globalModalIcon');
        const cancelBtn = document.getElementById('globalModalCancel');
        
        msgEl.innerText = message;
        
        if (type === 'error') {
            titleEl.innerText = title || 'Lỗi!';
            cancelBtn.style.display = 'none'; 
            iconEl.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>';
            iconEl.className = 'custom-modal-icon error';
        } else if (type === 'alert') {
            titleEl.innerText = title || 'Thông báo';
            cancelBtn.style.display = 'none';
            iconEl.innerHTML = '<i class="fa-solid fa-circle-info"></i>';
            iconEl.className = 'custom-modal-icon info';
        } else {
            titleEl.innerText = title || 'Xác nhận';
            cancelBtn.style.display = 'block'; 
            iconEl.innerHTML = '<i class="fa-solid fa-circle-question"></i>';
            iconEl.className = 'custom-modal-icon';
        }

        currentConfirmCallback = confirmCallback;
        overlay.classList.add('show');
    }

    function closeGlobalModal() {
        document.getElementById('globalCustomModal').classList.remove('show');
        currentConfirmCallback = null;
    }

    document.getElementById('globalModalCancel').addEventListener('click', closeGlobalModal);
    document.getElementById('globalModalConfirm').addEventListener('click', function() {
        if (currentConfirmCallback) {
            currentConfirmCallback(); 
        } else {
            closeGlobalModal(); 
        }
    });

    function confirmLink(event, message, url) {
        event.preventDefault(); 
        showGlobalModal(message, 'confirm', function() {
            window.location.href = url; 
        });
    }

    function confirmForm(event, message, formElement) {
        event.preventDefault(); 
        showGlobalModal(message, 'confirm', function() {
            formElement.submit(); 
        });
    }
</script>

<?php if (isset($_SESSION['flash_alert'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: "<?php echo $_SESSION['flash_alert']['icon']; ?>",
                title: "<?php echo $_SESSION['flash_alert']['title']; ?>",
                text: "<?php echo $_SESSION['flash_alert']['text']; ?>"
            });
        });
    </script>
    <?php unset($_SESSION['flash_alert']); ?>
<?php endif; ?>

</body>
</html>