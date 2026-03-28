<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>

<link rel="stylesheet" href="/assets/user/css/product.css">
<link rel="stylesheet" href="/assets/user/css/category.css">

<main class="container-main product-page">
    <div class="breadcrumb">
        <a href="/">Trang chủ</a> <span>/</span>
        <a href="/san-pham?ma_danhmuc=<?php echo $sp['ma_danhmuc']; ?>"><?php echo $c['ten_danhmuc']; ?></a> <span>/</span>
        <span class="current"><?php echo $sp['tensp']; ?></span>
    </div>

    <div class="product-top-section card-box">
        
        <div class="product-gallery gallery-right-thumb">
            <div class="main-image-container fixed-size">
                <img id="mainProductImage" src="/uploads/books/<?php echo $sp['link_hinhanh']; ?>" alt="<?php echo $sp['tensp']; ?>">
            </div>

            <div class="thumbnail-list-vertical-right">
                <div class="thumb-item active" onclick="changeImage(this, '/uploads/books/<?php echo $sp['link_hinhanh']; ?>')">
                    <img src="/uploads/books/<?php echo $sp['link_hinhanh']; ?>" alt="Thumb">
                </div>
                <div class="thumb-item" onclick="changeImage(this, '/uploads/books/sach_1.png')">
                    <img src="/uploads/books/sach_1.png" alt="Thumb">
                </div>
                <div class="thumb-item" onclick="changeImage(this, '/uploads/books/sach_2.png')">
                    <img src="/uploads/books/sach_2.png" alt="Thumb">
                </div>
            </div>
        </div>

        <div class="product-info-right">
            <h1 class="product-title"><?php echo $sp['tensp']; ?></h1>
            <p style="color: var(--text-muted); margin-bottom: 10px;">Mã sản phẩm: <strong><?php echo $sp['ma_sp']; ?></strong></p>
            
            <div class="product-price">
                <span class="new-price"><?php echo number_format($sp['giasp']); ?> ₫</span>
            </div>

            <form action="/gio-hang/them" method="POST" class="add-to-cart-form">
                <input type="hidden" name="ma_sp" value="<?php echo $sp['ma_sp']; ?>">
                
                <div class="product-options">
                    <h3>Phiên bản:</h3>
                    <div class="option-group">
                        <?php 
                            $phien_ban_arr = [];
                            foreach($product_info as $item) {
                                if(!in_array($item['phien_ban'], $phien_ban_arr)) {
                                    $phien_ban_arr[] = $item['phien_ban'];
                                }
                            }
                            foreach($phien_ban_arr as $index => $pb) {
                                $checked = ($index == 0) ? 'checked' : ''; 
                        ?>
                                <label class="option-item">
                                    <input type="radio" name="phien_ban" value="<?php echo $pb; ?>" <?php echo $checked; ?>>
                                    <span><?php echo $pb; ?></span>
                                </label>
                        <?php } ?>
                    </div>
                </div>

                <div class="product-options">
                    <h3>Chất liệu:</h3>
                    <div class="option-group">
                        <?php 
                            $chat_lieu_arr = [];
                            foreach($product_info as $item) {
                                if(!in_array($item['chat_lieu'], $chat_lieu_arr)) {
                                    $chat_lieu_arr[] = $item['chat_lieu'];
                                }
                            }
                            foreach($chat_lieu_arr as $index => $cl) {
                                $checked = ($index == 0) ? 'checked' : '';
                        ?>
                                <label class="option-item">
                                    <input type="radio" name="chat_lieu" value="<?php echo $cl; ?>" <?php echo $checked; ?>>
                                    <span><?php echo $cl; ?></span>
                                </label>
                        <?php } ?>
                    </div>
                </div>

                <div class="product-quantity">
                    <h3>Số lượng:</h3>
                    <div class="qty-control">
                        <button type="button" class="qty-btn" onclick="decreaseQty()">-</button>
                        <input type="number" id="qtyInput" name="soluong" value="1" min="1" max="100">
                        <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <div class="product-actions">
                    <?php if(!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) { ?>
                        <div style="width: 100%;">
                            <p style="color: #d0011b; font-weight: 600; margin-bottom: 10px;"> Vui lòng đăng nhập để đặt hàng!</p>  
                            <a href="/dang-nhap" class="btn-primary" style="display: block; text-align: center;">Về trang đăng nhập</a>
                        </div>
                    <?php } else { ?>
                        <button type="submit" class="btn-primary btn-add-cart">
                            <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                    <?php } ?>
                </div>
            </form>

        </div>
    </div>

    <div class="product-details-section card-box">
        <h2 class="section-title-sm">Thông tin chi tiết</h2>
        <table class="specs-table">
            <tbody>
                <tr><td>Nhà xuất bản</td><td><?php echo isset($sp['nxb']) ? $sp['nxb'] : 'Đang cập nhật'; ?></td></tr>
                <tr><td>Tác giả</td><td><?php echo isset($sp['tac_gia']) ? $sp['tac_gia'] : 'Đang cập nhật'; ?></td></tr>
            </tbody>
        </table>

        <h2 class="section-title-sm" style="margin-top: 40px;">Mô tả sản phẩm</h2>
        <div class="product-description-content">
            <p><?php echo isset($sp['motasp']) ? nl2br($sp['motasp']) : 'Chưa có mô tả cho sản phẩm này.'; ?></p>
        </div>
    </div>

    <div class="product-reviews-section card-box">
            <h2 class="section-title-sm">Đánh giá & Bình luận khách hàng</h2>
            <div class="reviews-container">
                <div class="review-item">
                    <div class="reviewer-avatar"><img src="/assets/user/img/logo_user.png" alt="User"></div>
                    <div class="reviewer-info">
                        <h4>Nguyễn Văn A</h4>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <span class="review-date">12/03/2025</span>
                        <p class="review-text">Sách bọc cẩn thận, giao hàng rất nhanh. Nội dung sách cực kỳ lôi cuốn và ý nghĩa. Rất đáng tiền!</p>
                    </div>
                </div>
                <div class="review-item">
                    <div class="reviewer-avatar"><img src="/assets/user/img/logo_user.png" alt="User"></div>
                    <div class="reviewer-info">
                        <h4>Trần Thị B</h4>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                        <span class="review-date">10/03/2025</span>
                        <p class="review-text">Sách hay, bìa thiết kế đẹp nhưng hộp lúc giao bị móp một chút. Đánh giá shop 4 sao.</p>
                    </div>
                </div>
            </div>
            <div class="write-review-box">
                <textarea placeholder="Viết bình luận của bạn về cuốn sách này..."></textarea>
                <button class="btn-primary">Gửi đánh giá</button>
            </div>
        </div>

    <div class="related-products-section">
            <div class="section-title-wrap">
                <h2 class="section-title">Sản phẩm cùng danh mục</h2>
            </div>
            
            <div class="cartegory_right_content">
                <?php
                    $list_product = $related_products;

                    if (!empty($list_product) && count($list_product) > 0):
                        foreach ($list_product as $rel_sp):
                            $gia_ban = $rel_sp['giasp'];
                            $gia_goc = $gia_ban * 1.25; 
                            $phan_tram_giam = round((($gia_goc - $gia_ban) / $gia_goc) * 100);
                ?>
                    <div class="product-item">
                        <a href="/san-pham/chi-tiet/<?php echo $rel_sp['ma_sp']; ?>" class="product-link">
                            
                            <div class="discount-badge">-<?php echo $phan_tram_giam; ?>%</div>
                            
                            <div class="product_img">
                                <img src="/uploads/books/<?php echo $rel_sp['link_hinhanh']; ?>" alt="<?php echo $rel_sp['tensp']; ?>">
                            </div>
                            
                            <h3 class="product-name"><?php echo $rel_sp['tensp']; ?></h3>
                            
                            <div class="product-price-box">
                                <span class="old-price"><?php echo number_format($gia_goc); ?> ₫</span>
                                <span class="new-price"><?php echo number_format($gia_ban); ?> ₫</span>
                            </div>
                            
                            <button class="btn-buy-now">Mua ngay</button>
                        </a>
                    </div>
                <?php
                        endforeach;
                    else:
                ?>
                    <p class="empty-product">Không có sản phẩm nào để hiển thị.</p>
                <?php
                    endif; 
                ?>
            </div>
        </div>

</main>

<script>
    function changeImage(element, imageSrc) {
        document.getElementById('mainProductImage').src = imageSrc;
        var thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach(function(thumb) {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }

    function increaseQty() {
        var input = document.getElementById('qtyInput');
        input.value = parseInt(input.value) + 1;
    }
    function decreaseQty() {
        var input = document.getElementById('qtyInput');
        if(parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>