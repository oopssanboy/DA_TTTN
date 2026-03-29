<link rel="stylesheet" href="/assets/user/css/auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>MẬT KHẨU MỚI</h2>
            <p>Tuyệt vời! Hãy tạo một mật khẩu mới cho tài khoản của bạn.</p>
        </div>
        <form action="/dat-lai-mat-khau" method="POST" class="auth-form">
            <div class="input-group">
                <label>Mật khẩu mới</label>
                <input type="password" name="matkhau_moi" placeholder="Nhập mật khẩu mới" required minlength="6">
            </div>
            <div class="input-group">
                <label>Xác nhận mật khẩu mới</label>
                <input type="password" name="xacnhan_matkhau" placeholder="Nhập lại mật khẩu mới" required minlength="6">
            </div>
            <button type="submit" class="btn-auth-submit">ĐỔI MẬT KHẨU</button>
        </form>
    </div>
</div>