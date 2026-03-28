<?php
class ShopController extends Controller {

    public function index() {
        $category_model = $this->model('Category');
        $product_model = $this->model('Sach');
        $brand_model = $this->model('NXB');
        $dd_sp = $this->model('Dacdiem_sp');

        // Nhận các tham số lọc từ URL (GET)
        $ma_danhmuc = isset($_GET['ma_danhmuc']) ? $_GET['ma_danhmuc'] : '';
        $phan_loai = isset($_GET['phan_loai']) ? $_GET['phan_loai'] : '';
        $sap_xep = isset($_GET['sap_xep']) ? $_GET['sap_xep'] : '';
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        $brand_selected = isset($_GET['nxb']) ? $_GET['nxb'] : [];
        $chat_lieu = isset($_GET['chat_lieu']) ? $_GET['chat_lieu'] : '';
        $phien_ban = isset($_GET['phien_ban']) ? $_GET['phien_ban'] : '';

        // Xử lý tiêu đề trang
        $c = "Tất cả sản phẩm";
        if ($ma_danhmuc != '') {
            $category_detail = $category_model->getByid_dm($ma_danhmuc);
            if (!empty($category_detail)) {
                $c = $category_detail[0]['ten_danhmuc'];
            }
        }
        if ($keyword != '' ) {
            $c = "Kết quả tìm kiếm: '" . htmlspecialchars($keyword) . "'";  
        }

        // Lấy dữ liệu cho các Sidebar Bộ lọc
        $list_brand = $brand_model->getAll(); // Đã dùng đúng hàm mới
        $list_phanloai = $product_model->getAll_phanloai();
        $list_dd_sp_chatlieu = $dd_sp->getAll_groupby_chatlieu();
        $list_dd_sp_phienban = $dd_sp->getAll_groupby_phien_ban();
        
        // Lọc sản phẩm
        $list_product = $product_model->loc_san_pham($ma_danhmuc, $phan_loai, $sap_xep, $brand_selected, $chat_lieu, $phien_ban, $keyword);

        // Gói dữ liệu truyền ra View
        $data = [
            'title' => $c . ' - Chapter One',
            'c' => $c,
            'ma_danhmuc' => $ma_danhmuc,
            'phan_loai' => $phan_loai,
            'sap_xep' => $sap_xep,
            'keyword' => $keyword,
            'brand_selected' => $brand_selected,
            'chat_lieu' => $chat_lieu,
            'phien_ban' => $phien_ban,
            'list_brand' => $list_brand,
            'list_phanloai' => $list_phanloai,
            'list_dd_sp_chatlieu' => $list_dd_sp_chatlieu,
            'list_dd_sp_phienban' => $list_dd_sp_phienban,
            'list_product' => $list_product
        ];

        $this->view('user/shop/category', $data);
    }
}
?>