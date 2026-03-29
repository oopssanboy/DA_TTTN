<link rel="stylesheet" href="/assets/user/css/auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .otp-input-box { text-align: center; font-size: 28px; letter-spacing: 15px; font-weight: bold; padding: 15px; width: 100%; border: 1px solid #e8e8e8; border-radius: 6px; outline: none; }
    .otp-input-box:focus { border-color: #d97706; box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15); }
    .otp-input-box::placeholder { font-size: 16px; letter-spacing: normal; font-weight: normal; }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <a href="/quen-mat-khau" class="back-home"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            <h2>XÁC THỰC EMAIL</h2>
            <p>Mã OTP 6 số đã được gửi đến email của bạn.</p>
        </div>
        <form action="/xac-thuc-otp-pass" method="POST" class="auth-form">
            <div class="input-group" style="margin-bottom: 30px;">
                <input type="text" name="otp" class="otp-input-box" placeholder="Nhập 6 số" required maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
            <button type="submit" class="btn-auth-submit">XÁC NHẬN MÃ</button>
        </form>
    </div>
</div>