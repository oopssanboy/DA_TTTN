<?php require ROOT_DIR . '/app/views/user/layouts/header.php'; ?>
<link rel="stylesheet" href="/assets/admin/css/admin.css">

<div class="admin-wrapper">
    <?php require ROOT_DIR . '/app/views/admin/layouts/sidebar.php'; ?>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
        <div class="mobile-menu-toggle">
            <button class="btn-toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i> Menu</button>
        </div>

        <div class="card-box">
            <h2 class="page-title">Quản Lý Đánh Giá Sản Phẩm</h2>
            
            <table style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách Hàng</th>
                        <th>Sản Phẩm</th>
                        <th>Số Sao</th>
                        <th style="width: 30%;">Nội Dung</th>
                        <th>Ngày Đăng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reviews) && count($reviews) > 0): ?>
                        <?php foreach ($reviews as $rev): ?>
                            <tr>
                                <td><strong>#<?= $rev['ma_review'] ?></strong></td>
                                <td><?= htmlspecialchars($rev['ten_kh']) ?></td>
                                <td>
                                    <a href="/san-pham/chi-tiet/<?= $rev['ma_sp'] ?>" target="_blank" style="text-decoration: none; font-weight: 500;">
                                        <?= htmlspecialchars($rev['tensp']) ?> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px; margin-left: 3px;"></i>
                                    </a>
                                </td>
                                <td style="color: #f39c12; font-size: 14px;">
                                    <?php 
                                        for($i = 1; $i <= 5; $i++) {
                                            echo ($i <= $rev['sosao']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star" style="color: #ccc;"></i>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <div style="max-height: 80px; overflow-y: auto; font-size: 14px; text-align: center;">
                                        <?= nl2br(htmlspecialchars($rev['noidung'])) ?>
                                    </div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($rev['ngay_bl'])) ?></td>
                                <td>
                                    <a href="/admin/danh-gia/xoa/<?= $rev['ma_review'] ?>" class="btn btn-xoa" onclick="confirmLink(event, 'Xác nhận xóa vĩnh viễn bình luận này?', this.href);">
                                        <i class="fa-solid fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align: center; padding: 30px 0; color: #777;">Chưa có đánh giá/bình luận nào trên hệ thống.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require ROOT_DIR . '/app/views/user/layouts/footer.php'; ?>

<script>
    // Hàm bật/tắt menu trên mobile (Giữ nguyên của bạn)
    function toggleSidebar() { 
        document.querySelector('.admin-sidebar').classList.toggle('show'); 
        document.getElementById('sidebarOverlay').classList.toggle('show'); 
    }
</script>