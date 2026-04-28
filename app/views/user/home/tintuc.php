<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>

<main class="container-main" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    <div class="breadcrumb" style="margin-bottom: 20px;">
        <a href="/">Trang chủ</a> <span>/</span>
        <span class="current">Mã khuyến mãi & Ưu đãi</span>
    </div>

    <div class="card-box" style="padding: 30px; border-top: 5px solid var(--primary-color);">
        <h2 style="margin-top: 0; color: var(--text-main); text-transform: uppercase; letter-spacing: 1px;">
            <i class="fa-solid fa-ticket" style="color: var(--primary-color);"></i> Tổng hợp mã giảm giá
        </h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">
            Sử dụng các mã giảm giá dưới đây tại bước thanh toán giỏ hàng để nhận ưu đãi từ Chapter One.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
            <?php if (!empty($list_coupons)): ?>
                <?php foreach ($list_coupons as $cp): ?>
                    <div class="coupon-card" style="display: flex; border: 2px dashed #d97706; border-radius: 10px; overflow: hidden; background: #fffcf5;">
                        <div style="background: var(--primary-color); color: white; padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 100px;">
                            <span style="font-size: 24px; font-weight: 800;">
                                <?= ($cp['type'] == 'percent') ? $cp['value'] . '%' : number_format($cp['value']/1000) . 'k' ?>
                            </span>
                            <span style="font-size: 12px; text-transform: uppercase;">Giảm</span>
                        </div>
                        
                        <div style="padding: 15px; flex: 1; position: relative;">
                            <h3 style="margin: 0 0 8px 0; font-size: 16px; color: #333;">Mã: <span style="color: #d0011b; font-family: monospace; font-size: 18px;"><?= $cp['code'] ?></span></h3>
                            <p style="font-size: 13px; margin: 5px 0; color: #555;">
                                <i class="fa-solid fa-circle-info"></i> Đơn tối thiểu: <strong><?= number_format($cp['min_order_value']) ?>đ</strong>
                            </p>
                            <p style="font-size: 13px; margin: 5px 0; color: #d0011b;">
                                <i class="fa-solid fa-hourglass-end"></i> Hết hạn: <?= date('d/m/Y', strtotime($cp['end_date'])) ?>
                            </p>
                            
                            <button onclick="copyCode('<?= $cp['code'] ?>')" style="margin-top: 10px; background: #333; color: white; border: none; padding: 5px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; transition: 0.3s;">
                                <i class="fa-regular fa-copy"></i> Sao chép mã
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <img src="/assets/user/img/empty-coupon.png" alt="No coupon" style="width: 150px; opacity: 0.5;">
                    <p style="color: #888; margin-top: 20px;">Hiện tại không có mã giảm giá nào khả dụng. Hãy quay lại sau nhé!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        alert("Đã sao chép mã: " + code);
    });
}
</script>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>