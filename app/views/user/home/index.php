<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>

<div id="intro-splash">
    <div class="splash-3d-grid"></div>
    <div class="splash-content">
        <h1 class="splash-title">CHAPTER ONE</h1>
        <p class="splash-subtitle">The Beginning</p>
        </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const splash = document.getElementById('intro-splash');
        if (!sessionStorage.getItem('hasSeenSplash')) {
            sessionStorage.setItem('hasSeenSplash', 'true');
       splash.addEventListener('click', function() {
                splash.classList.add('splash-hidden');
                setTimeout(() => {
                    if(splash) splash.remove();
                }, 800);
            }); 
            } else {
            splash.style.display = 'none';
            splash.remove();
        }
    });
</script>
<section class="hero-full-width">
    <?php include_once ROOT_DIR . '/app/views/user/slide/slide.php'; ?>    
</section>

<main class="container-main">
    <section class="home-section">
        <div class="section-title-wrap">
            <h2 class="section-title">Sách mới tuyển chọn</h2>
            <a href="/" class="view-all">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
        </div>
        <div class="product-grid-wrapper">
            
            <?php 
            $tab = '';
            include ROOT_DIR . '/app/views/user/product/product_mid.php'; ?>
        </div>
    </section>

    <section class="home-section">
        <div class="section-title-wrap">
            <h2 class="section-title">Khuyến mãi - Giảm đến 25%</h2>
            <a href="/" class="view-all">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
        </div>
        <div class="product-grid-wrapper">
            <?php 
            $tab = '';
            include ROOT_DIR . '/app/views/user/product/product_mid.php'; ?>
        </div>
    </section>

    <section class="home-section intro-section">
        <div class="intro-content">
            <h2>VỀ CHAPTER ONE</h2>
            <p>Khám phá kho tàng tri thức vô tận với hàng ngàn đầu sách đa dạng thể loại. Chúng tôi cam kết mang đến cho bạn những tác phẩm chất lượng nhất, chắp cánh cho những ước mơ và sự nghiệp của bạn. Đọc để dẫn đầu, nâng tầm tri thức.</p>
            <a href="/gioi-thieu" class="btn-primary">Tìm hiểu thêm về chúng tôi</a>
        </div>
    </section>

    <section class="home-section">
        <div class="section-title-wrap">
            <h2 class="section-title">Bán tốt nhất</h2>
            <a href="/" class="view-all">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
        </div>
        <div class="product-grid-wrapper">
            <?php 
            $tab = 'sachbanchay';
            include ROOT_DIR . '/app/views/user/product/product_mid.php'; ?>
        </div>
    </section>


<section class="life-books-banner">
    <img src="/assets/user/img/banner_khampha.jpg" alt="Sách về cuộc sống">
    <div class="banner-overlay">
        <h2>Sách Về Cuộc Sống</h2>
        <p>Tuyển tập những cuốn sách truyền cảm hứng, chữa lành và thay đổi tư duy của bạn.</p>
        <a href="/" class="btn-primary">Khám phá ngay</a>
    </div>
</section>
<section class="home-section">
        <div class="section-title-wrap">
            <h2 class="section-title">TUYỂN TẬP CUỐN SÁCH HAY</h2>
            <a href="/" class="view-all">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
        </div>
        <div class="product-grid-wrapper">
            
            <?php 
            $tab = 'sachhay';
            include ROOT_DIR . '/app/views/user/product/product_mid.php'; ?>
        </div>
    </section>
</main> 
<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>