
<div class="cartegory_right_content">
    <?php
        if (!isset($list_product)) {
            if (class_exists('Sach')) {
                $product = new Sach();
                $list_product = $product->getAll_limit8($tab ?? "");   
            }
        }

        if (!empty($list_product) && count($list_product) > 0):
            $sach_model = new Sach(); // Khởi tạo để gọi getActiveDiscount
            foreach ($list_product as $sp):
                // Logic tính giá từ bảng product_discounts
                $gia_niem_yet = $sp['giasp'];
                $percent = $sach_model->getActiveDiscount($sp['ma_sp']); 
                $gia_ban_moi = ($percent > 0) ? ($gia_niem_yet * (100 - $percent) / 100) : $gia_niem_yet;
    ?>
                <div class="product-item">
                    <a href="/san-pham/chi-tiet/<?php echo $sp['ma_sp']; ?>" class="product-link">
                        
                        <?php if($percent > 0): ?>
                            <div class="discount-badge">-<?php echo $percent; ?>%</div>
                        <?php endif; ?>
                        
                        <div class="product_img">
                            <img src="/uploads/books/<?php echo $sp['link_hinhanh']; ?>" alt="<?php echo $sp['tensp']; ?>">
                        </div>
                        
                        <h3 class="product-name"><?php echo $sp['tensp']; ?></h3>

                        <div class="product-rating" style="font-size: 12px; color: #f39c12; margin-bottom: 8px; margin-top: -16px; display: flex; align-items: center; gap: 3px; justify-content: center;">
                            <?php 
                                $sao_avg = isset($sp['sao_avg']) ? round($sp['sao_avg'] * 2) / 2 : 0;
                                if ($sao_avg > 0) {
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $sao_avg) echo '<i class="fa-solid fa-star"></i>';
                                        elseif ($i - 0.5 <= $sao_avg) echo '<i class="fa-solid fa-star-half-stroke"></i>';
                                        else echo '<i class="fa-regular fa-star" style="color: #ddd;"></i>';
                                    }
                                    echo '<span style="color: #777; font-size: 11px; margin-left: 5px;">(' . number_format($sp['sao_avg'], 1) . ')</span>';
                                } else {
                                    for ($i = 1; $i <= 5; $i++) echo '<i class="fa-regular fa-star" style="color: #ddd;"></i>';
                                    echo '<span style="color: #999; font-size: 11px; margin-left: 5px;">(0)</span>';
                                }
                            ?>
                        </div>

                        <div class="product-price-box">
                            <?php if($percent > 0): ?>
                                <span class="old-price" style="text-decoration: line-through; color: #888; margin-right: 5px;">
                                    <?php echo number_format($gia_niem_yet); ?> ₫
                                </span>
                            <?php endif; ?>
                            <span class="new-price" style=" font-weight: bold;">
                                <?php echo number_format($gia_ban_moi); ?> ₫
                            </span>
                        </div>
                        
                        <button class="btn-buy-now">Mua ngay</button>
                    </a>
                </div>
    <?php
            endforeach;
            unset($list_product);
        else:
    ?>
            <p class="empty-product">Không có sản phẩm nào để hiển thị.</p>
    <?php
        endif; 
    ?>
</div>