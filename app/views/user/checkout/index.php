<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THANH TOAN</title>
    <style>
        body { background-color: #f9f9f9; }
        .qr-container { display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 20px; }
        .qr { background-color: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); display: flex; flex-direction: column; align-items: center; text-align: center; max-width: 500px; width: 100%; border: 1px solid #eee; }
        .qr h1 { font-size: 24px; color: #333; margin-bottom: 20px; text-transform: uppercase; border-bottom: 2px solid #d97706; padding-bottom: 10px; display: inline-block; }
        .qr img { width: 100%; max-width: 300px; height: auto; border: 1px solid #ddd; padding: 10px; border-radius: 10px; margin-bottom: 20px; background: #fff; }
        .payment-details { text-align: left; background: #f4f5f7; padding: 15px 20px; border-radius: 8px; width: 100%; margin-bottom: 25px; font-size: 14px; color: #444; }
        .payment-details p { margin: 8px 0; line-height: 1.5; }
        .qr form { width: 100%; }
        .qr button { width: 100%; padding: 15px; background-color: #333; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px; }
        .qr button:hover { background-color: #d97706; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(217, 119, 6, 0.4); }
        @media (max-width: 768px) { .qr { padding: 20px; margin: 20px; } .qr h1 { font-size: 20px; } }
    </style>
</head>
<body>
    <?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>
    
    <div class="qr-container">
        <div class="qr">
            <h1>Chuyển khoản ngân hàng</h1>
            <p style="margin-bottom: 10px; color: #666;">Mở ứng dụng ngân hàng và quét mã QR bên dưới để thanh toán tự động.</p>
            
            <img src="<?php echo $qr_url; ?>" alt="Mã QR Chuyển Khoản">
            
            <div class="payment-details">
                <p><strong>Ngân hàng:</strong> <?php echo $bank_id; ?></p>
                <p><strong>Chủ tài khoản:</strong> <?php echo $account_name; ?></p>
                <p><strong>Số tài khoản:</strong> <span style="color: #d97706; font-weight: bold; font-size: 16px;"><?php echo $account_no; ?></span></p>
                <?php if(isset($tongtien)): ?>
                    <p><strong>Số tiền:</strong> <span style="color: #d0011b; font-weight: bold; font-size: 18px;"><?= number_format($tongtien) ?> VNĐ</span></p>
                <?php endif; ?>
                <p style="margin-bottom: 0;"><strong>Nội dung:</strong> <span style="font-weight: bold;"><?php echo $description; ?></span></p>
            </div>

            <form method="POST" action="/xac-nhan-thanh-toan-qr">
                <button type="submit">Xác nhận đã chuyển khoản</button>
            </form>
        </div>
    </div>

    <?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>
</body>
</html>