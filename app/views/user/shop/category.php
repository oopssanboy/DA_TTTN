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
                <div class="row">
                    <div class="cartegory_right_top_item">
                        <p><?php echo $c; ?></p>
                    </div>
                    <div class="cartegory_right_top_item">
                        <select onchange="updateSortAndSubmit(this.value)">
                            <option value="">Sắp xếp mặc định</option>
                            <option value="gia_giam" <?php if ($sap_xep == 'gia_giam') echo 'selected'; ?>>Giá cao đến thấp</option>
                            <option value="gia_tang" <?php if ($sap_xep == 'gia_tang') echo 'selected'; ?>>Giá thấp đến cao</option>
                        </select>
                    </div>
                </div>

                <?php 
                    // Yêu cầu bạn di chuyển file product_mid.php cũ vào app/views/user/shop/product_mid.php
                    require ROOT_DIR . '/app/views/user/product/product_mid.php'; 
                ?>
                
            </div>
        </div>
    </div>
    
    <div class="cartegory_right_bottom row">
        <div class="cartegory_right_bottom_item">
            <p>Hiển thị danh sách Sản phẩm </p>
        </div>
        <div class="cartegory_right_bottom_item">
            <p><span>&#171;</span> 1 2 3 4 5 <span>&#187;</span> Trang cuối</p>
        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>

<script>
    function updateSortAndSubmit(sortValue) {
        document.getElementById('hiddenSort').value = sortValue;
        document.getElementById('mainFilterForm').submit();
    }
</script>