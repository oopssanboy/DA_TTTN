
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