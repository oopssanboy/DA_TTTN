
<div class="cartegory_right_content">
    <?php

        if (!isset($list_product)) {
       
            if (class_exists('Sach')) {
                $product = new Sach();
                $list_product = $product->getAll_limit8($tab ?? "");   
            }
        }

        if (!empty($list_product) && count($list_product) > 0):
            foreach ($list_product as $sp):
      
                $gia_ban = $sp['giasp'];
                $gia_goc = $gia_ban * 1.25; 
                $phan_tram_giam = round((($gia_goc - $gia_ban) / $gia_goc) * 100);
    ?>
                <div class="product-item">
                    <a href="/san-pham/chi-tiet/<?php echo $sp['ma_sp']; ?>" class="product-link">
                        
                        <div class="discount-badge">-<?php echo $phan_tram_giam; ?>%</div>
                        
                        <div class="product_img">
                            <img src="/uploads/books/<?php echo $sp['link_hinhanh']; ?>" alt="<?php echo $sp['tensp']; ?>">
                        </div>
                        
                        <h3 class="product-name"><?php echo $sp['tensp']; ?></h3>
                        <div class="product-rating" style="font-size: 12px; color: #f39c12; margin-bottom: 8px; margin-top: -16px; display: flex; align-items: center; gap: 3px; justify-content: center;">
                            <?php 
                                // Làm tròn sao đến 0.5 (VD: 4.2 thành 4.0, 4.3 thành 4.5)
                                $sao_avg = isset($sp['sao_avg']) ? round($sp['sao_avg'] * 2) / 2 : 0;
                                
                                if ($sao_avg > 0) {
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $sao_avg) {
                                            echo '<i class="fa-solid fa-star"></i>'; // Sao đầy
                                        } elseif ($i - 0.5 <= $sao_avg) {
                                            echo '<i class="fa-solid fa-star-half-stroke"></i>'; // Sao rưỡi
                                        } else {
                                            echo '<i class="fa-regular fa-star" style="color: #ddd;"></i>'; // Sao rỗng
                                        }
                                    }
                                    // In số sao thực tế bên cạnh
                                    echo '<span style="color: #777; font-size: 11px; margin-left: 5px;">(' . number_format($sp['sao_avg'], 1) . ')</span>';
                                } else {
                                    // Chưa có đánh giá
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo '<i class="fa-regular fa-star" style="color: #ddd;"></i>';
                                    }
                                    echo '<span style="color: #999; font-size: 11px; margin-left: 5px;">(0)</span>';
                                }
                            ?>
                        </div>
                        <div class="product-price-box">
                            <span class="old-price"><?php echo number_format($gia_goc); ?> ₫</span>
                            <span class="new-price"><?php echo number_format($gia_ban); ?> ₫</span>
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