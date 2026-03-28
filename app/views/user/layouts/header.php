<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Cửa hàng sách Chapter One' ?></title>
    
    <link rel="stylesheet" href="/assets/user/css/style.css">
    <link rel="stylesheet" href="/assets/user/css/product.css">
    <link rel="stylesheet" href="/assets/user/css/category.css">
    <link rel="stylesheet" href="/assets/user/css/cart.css">
    <link rel="stylesheet" href="/assets/user/css/header.css">
    <link rel="stylesheet" href="/assets/user/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="site-header" id="myHeader">
        <div class="header-top">
            <div class="top-container">
                <div class="top-item top-phone">
                    <i class="fa-solid fa-phone"></i> <span>0964789010</span>
                </div>
                
                <div class="top-item top-search">
                    <form action="/san-pham" method="GET" class="search-form">
                        <input type="text" name="keyword" placeholder="Tìm kiếm sách, tác giả..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>

                <div class="top-item top-actions">
                    <div class="action-box lang-selector">
                        <span class="action-text"><i class="fa-solid fa-globe"></i> VN <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></span>
                        <ul class="dropdown-menu">
                            <li><a href="#">Tiếng Việt</a></li>
                            <li><a href="#">English</a></li>
                        </ul>
                    </div>

                    <div class="action-box auth-box">
                        <?php if (!isset($_SESSION['admin_login']) && !isset($_SESSION['user_login'])): ?>
                            <a href="/dang-nhap" class="btn-login">Đăng nhập</a>
                            <ul class="dropdown-menu">
                                <li><a href="/dang-ky">Đăng ký tài khoản</a></li>
                            </ul>
                        <?php else: ?>
                            <?php 
                                // Nếu có session hình ảnh thì lấy, không thì dùng avatar mặc định (đã cập nhật đường dẫn)
                                $avatar = isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : '/assets/user/img/dora.png'; 
                                $dashboard_link = isset($_SESSION['admin_login']) ? '/admin' : '/tai-khoan';
                            ?>
                            <div class="user-avatar-wrapper">
                                <img src="<?php echo $avatar; ?>" alt="Avatar" class="user-avatar">
                            </div>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $dashboard_link; ?>">Quản lý tài khoản</a></li>
                                <li><a href="/dang-xuat" onclick="confirmLink(event, 'Bạn có chắc chắn muốn đăng xuất?', this.href);">Đăng xuất</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="action-box cart-box">
                        <a href="/gio-hang" class="cart-link">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="cart-badge">
                                <?php
                                    if(!isset($_SESSION['user_cart']) || empty($_SESSION['user_cart'])){
                                        echo "0";
                                    }else{
                                        echo $_SESSION['user_cart']['count'];
                                    }
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-middle" id="headerMiddle">
            <div class="logo-container">
                <a href="/">
                    <img src="/assets/user/img/logo.png" alt="Mona Books" class="main-logo">
                </a>
            </div>
        </div>

        <div class="header-bottom">
            <ul class="main-menu">
                <li><a href="/">Trang chủ</a></li>
                <li class="has-dropdown">
                    <a href="/san-pham">Danh mục <i class="fa-solid fa-chevron-down" style="font-size: 11px; margin-left: 3px;"></i></a>
                    <ul class="sub_menu">
                        <?php
                            
                            if (class_exists('Category')) {
                                $category = new Category();
                                $list_ct = $category->getAll_dm();
                                if(count($list_ct) > 0):
                                    foreach($list_ct as $cat){
                        ?>
                                <li><a href="/san-pham?ma_danhmuc=<?php echo $cat['ma_danhmuc']?>"><?php echo htmlspecialchars($cat['ten_danhmuc'])?></a></li> 
                        <?php 
                                    } 
                                else: 
                        ?>
                                <li><a href="#">Đang cập nhật...</a></li>
                        <?php 
                                endif; 
                            }
                        ?>
                    </ul>
                </li>
                <li><a href="/gioi-thieu">Giới thiệu</a></li>
                <li><a href="/tin-tuc">Tin tức</a></li>
                <li><a href="/lien-he">Liên hệ</a></li>
            </ul>
        </div>
    </header>

    <script>
        window.addEventListener('scroll', function() {
            var header = document.getElementById('myHeader');
            if (window.scrollY > 80) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });
    </script>