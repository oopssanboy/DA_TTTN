

<link rel="stylesheet" href="/assets/user/css/auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<head>
    <title>Register - Chapter One</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
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

<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <a href="/" class="back-home"><i class="fa-solid fa-arrow-left"></i> Trang chủ</a>
            <h2>ĐĂNG KÝ</h2>
            <p>Tạo tài khoản để nhận nhiều ưu đãi từ Chapter One</p>
        </div>

        <form action="/xuly-dangky" method="POST" class="auth-form">
            <div class="input-group">
                <label>Email đăng ký</label>
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
            <div class="input-group">
                <label>Mật khẩu</label>
                <input type="password" name="matkhau" placeholder="Tạo mật khẩu" required>
            </div>
            <div class="input-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="xacnhan_matkhau" placeholder="Nhập lại mật khẩu" required>
            </div>
            
            <button type="submit" class="btn-auth-submit" style="margin-top: 15px;">Đăng Ký</button>
        </form>

        <div class="auth-divider">
            <span>Hoặc đăng ký bằng</span>
        </div>

        <div class="social-login-group">
            <a href="/auth/google" class="social-btn">
                <svg class="social-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                <span>Google</span>
            </a>

            <a href="/auth/facebook" class="social-btn">
                <svg class="social-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                <span>Facebook</span>
            </a>
        </div>

        <div class="auth-footer">
            Bạn đã có tài khoản? <a href="/dang-nhap">Đăng nhập ngay</a>
        </div>

    </div>
</div>

