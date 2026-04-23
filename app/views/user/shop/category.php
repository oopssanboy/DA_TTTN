<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>

<link rel="stylesheet" href="/assets/user/css/cartegory.css">

<div class="cartegory">
    <div class="container">
        <div class="cartegory_top row">
            <p><a href="/">Trang chủ</a></p>
            <span>/</span>
            <p><a href="/danh-muc<?php echo $ma_danhmuc ? '?ma_danhmuc='.$ma_danhmuc : ''; ?>"><?php echo $c; ?></a></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
            <div class="cartegory_left">
                <form action="/danh-muc" method="GET" id="mainFilterForm">

                    <?php if ($ma_danhmuc != '') { ?>
                        <input type="hidden" name="ma_danhmuc" value="<?php echo $ma_danhmuc; ?>">
                    <?php } ?>

                    <input type="hidden" name="sap_xep" id="hiddenSort" value="<?php echo $sap_xep; ?>">
                    <input type="hidden" name="khoang_gia" id="hiddenPrice" value="<?php echo $khoang_gia ?? ''; ?>">
                    
                    <?php if ($keyword != '') { ?>
                        <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>">
                    <?php } ?>

                    <div class="filter-group">
                        <h3 class="filter-title">ĐỐI TƯỢNG</h3>
                        <ul class="filter-list">
                            <?php if (!empty($list_phanloai)) { ?>
                                <?php foreach ($list_phanloai as $pl) { ?>
                                    <?php $checked = ($phan_loai == $pl['phan_loai']) ? 'checked' : ''; ?>
                                    <li>
                                        <label>
                                            <input type="radio" name="phan_loai" value="<?php echo htmlspecialchars($pl['phan_loai']); ?>" onchange="this.form.submit()" <?php echo $checked; ?>>
                                            <?php echo htmlspecialchars($pl['phan_loai']); ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <li>
                                <label>
                                    <input type="radio" name="phan_loai" value="" onchange="this.form.submit()" <?php echo empty($phan_loai) ? 'checked' : ''; ?>> Bỏ chọn
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-group">
                        <h3 class="filter-title">NHÀ XUẤT BẢN</h3>
                        <ul class="filter-list scroll-box">
                            <?php if (!empty($list_brand)) { ?>
                                <?php foreach ($list_brand as $br) { ?>
                                    <?php $checked = in_array($br['ma_nxb'], (array) $brand_selected) ? 'checked' : ''; ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="nxb[]" value="<?php echo $br['ma_nxb']; ?>" onchange="this.form.submit()" <?php echo $checked; ?>>
                                            <?php echo htmlspecialchars($br['ten_nxb']); ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="filter-group">
                        <h3 class="filter-title">CHẤT LIỆU</h3>
                        <ul class="filter-list">
                        <?php if (!empty($list_dd_sp_chatlieu)) { ?>
                                <?php foreach ($list_dd_sp_chatlieu as $cl) { ?>
                                    <?php $checked = ($chat_lieu == $cl['chat_lieu']) ? 'checked' : ''; ?>
                                    <li>
                                        <label>
                                            <input type="radio" name="chat_lieu" value="<?php echo htmlspecialchars($cl['chat_lieu']); ?>" onchange="this.form.submit()" <?php echo $checked; ?>>
                                            <?php echo htmlspecialchars($cl['chat_lieu']); ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <li>
                                <label>
                                    <input type="radio" name="chat_lieu" value="" onchange="this.form.submit()" <?php echo empty($chat_lieu) ? 'checked' : ''; ?>> Bỏ chọn
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-group">
                        <h3 class="filter-title">PHIÊN BẢN</h3>
                        <ul class="filter-list">
                            <?php if (!empty($list_dd_sp_phienban)) { ?>
                                <?php foreach ($list_dd_sp_phienban as $pb) { ?>
                                    <?php $checked = ($phien_ban == $pb['phien_ban']) ? 'checked' : ''; ?>
                                    <li>
                                        <label>
                                            <input type="radio" name="phien_ban" value="<?php echo htmlspecialchars($pb['phien_ban']); ?>" onchange="this.form.submit()" <?php echo $checked; ?>>
                                            <?php echo htmlspecialchars($pb['phien_ban']); ?>
                                        </label>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <li>
                                <label>
                                    <input type="radio" name="phien_ban" value="" onchange="this.form.submit()" <?php echo empty($phien_ban) ? 'checked' : ''; ?>> Bỏ chọn
                                </label>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>

            <div class="cartegory_right">
                <div class="row" style="align-items: center; justify-content: space-between;">
                    <div class="cartegory_right_top_item">
                        <p><?php echo $c; ?></p>
                    </div>
                    
                    <div class="cartegory_right_top_item" style="display: flex; gap: 15px;">
                        
                        <select onchange="updatePriceAndSubmit(this.value)" style="padding: 10px 15px; margin-right: 10px; border: 1px solid #ddd; outline: none; border-radius: 4px; cursor: pointer;">
                            <option value="">Tất cả mức giá</option>
                            <option value="duoi_100" <?php if (($khoang_gia ?? '') == 'duoi_100') echo 'selected'; ?>>Dưới 100.000₫</option>
                            <option value="100_300" <?php if (($khoang_gia ?? '') == '100_300') echo 'selected'; ?>>100.000₫ - 300.000₫</option>
                            <option value="tren_300" <?php if (($khoang_gia ?? '') == 'tren_300') echo 'selected'; ?>>Trên 300.000₫</option>
                        </select>

                        <select onchange="updateSortAndSubmit(this.value)" style="padding: 10px 15px; margin-right: 20px; border: 1px solid #ddd; outline: none; border-radius: 4px; cursor: pointer;">
                            <option value="">Sắp xếp mặc định</option>
                            <option value="ban_chay" <?php if ($sap_xep == 'ban_chay') echo 'selected'; ?>>Bán chạy nhất</option>
                            <option value="danh_gia_cao" <?php if ($sap_xep == 'danh_gia_cao') echo 'selected'; ?>>Đánh giá cao nhất</option>
                            <option value="gia_giam" <?php if ($sap_xep == 'gia_giam') echo 'selected'; ?>>Giá cao đến thấp</option>
                            <option value="gia_tang" <?php if ($sap_xep == 'gia_tang') echo 'selected'; ?>>Giá thấp đến cao</option>
                        </select>
                        
                    </div>
                </div>

                <?php 
                   $so_luong_hien_thi = isset($list_product) ? count($list_product) : 0;
                   require ROOT_DIR . '/app/views/user/product/product_mid.php'; 
                ?>
                
                <div class="cartegory_right_bottom row" style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
                    <div class="cartegory_right_bottom_item">
                        <p>Hiển thị <strong><?= $so_luong_hien_thi ?></strong> / <strong><?= $total_products ?></strong> sản phẩm</p>
                    </div>
                    
                    <?php if (isset($total_pages) && $total_pages > 1): ?>
                        <div class="cartegory_right_bottom_item">
                            <ul class="pagination" style="display: inline-flex; list-style: none; padding: 0; gap: 8px;">
                                <?php 
                                    function buildPageUrl($pageNum) {
                                        $params = $_GET;
                                        $params['page'] = $pageNum;
                                        return '?' . http_build_query($params);
                                    }
                                ?>

                                <?php if ($current_page > 1): ?>
                                    <li>
                                        <a href="<?= buildPageUrl($current_page - 1) ?>" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #333; border-radius: 4px;">&#171;</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li>
                                        <a href="<?= buildPageUrl($i) ?>" style="padding: 8px 16px; border: 1px solid #ddd; text-decoration: none; border-radius: 4px; <?= ($i == $current_page) ? 'background-color: var(--primary-color, #d97706); color: white; border-color: var(--primary-color, #d97706);' : 'color: #333;' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <li>
                                        <a href="<?= buildPageUrl($current_page + 1) ?>" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #333; border-radius: 4px;">&#187;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>

<script>
    // Hàm cập nhật Sắp xếp
    function updateSortAndSubmit(sortValue) {
        document.getElementById('hiddenSort').value = sortValue;
        document.getElementById('mainFilterForm').submit();
    }

    // Hàm cập nhật Lọc Giá
    function updatePriceAndSubmit(priceValue) {
        document.getElementById('hiddenPrice').value = priceValue;
        document.getElementById('mainFilterForm').submit();
    }
</script>