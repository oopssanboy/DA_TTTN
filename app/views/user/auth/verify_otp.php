<link rel="stylesheet" href="/assets/user/css/auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<head>
    <title>Verify OTP - Chapter One</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<style>
    .otp-input-box {
        text-align: center !important;
        font-size: 28px !important;
        letter-spacing: 15px !important;
        font-weight: bold !important;
        padding: 15px !important;
    }
    .otp-input-box::placeholder {
        font-size: 16px;
        letter-spacing: normal;
        font-weight: normal;
    }
</style>
<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="auth-header">
            <a href="/dang-ky" class="back-home"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            <h2>XÁC THỰC EMAIL</h2>
            <p>Vui lòng kiểm tra hộp thư đến và nhập mã OTP 6 số vừa được gửi.</p>
        </div>

        <form action="/xac-thuc-otp" method="POST" class="auth-form">
            <div class="input-group" style="margin-bottom: 30px;">
                <label style="text-align: center;">Mã OTP</label>
                <input type="text" name="otp" class="otp-input-box" placeholder="Nhập 6 số" required 
                       maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
            
            <button type="submit" class="btn-auth-submit">XÁC NHẬN TÀI KHOẢN</button>
        </form>
        
        <div class="auth-footer" style="margin-top: 25px;">
            Không nhận được mã? <a href="/dang-ky">Gửi lại mã</a>
        </div>

    </div>
</div>