<link rel="stylesheet" href="/assets/user/css/auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <a href="/dang-nhap" class="back-home"><i class="fa-solid fa-arrow-left"></i> Đăng nhập</a>
            <h2>QUÊN MẬT KHẨU</h2>
            <p>Nhập email bạn đã đăng ký để nhận mã lấy lại mật khẩu.</p>
        </div>
        <form action="/quen-mat-khau" method="POST" class="auth-form">
            <div class="input-group">
                <label>Email của bạn</label>
                <input type="email" name="email" placeholder="Nhập email..." required>
            </div>
            <button type="submit" class="btn-auth-submit">GỬI MÃ XÁC NHẬN</button>
        </form>
    </div>
</div>