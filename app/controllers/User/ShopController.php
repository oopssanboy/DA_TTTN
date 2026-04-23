<?php
class ShopController extends Controller {

    public function index() {
        $category_model = $this->model('Category');
        $product_model = $this->model('Sach');
        $brand_model = $this->model('NXB');
        $dd_sp = $this->model('Dacdiem_sp');

        $ma_danhmuc = isset($_GET['ma_danhmuc']) ? $_GET['ma_danhmuc'] : '';
        $phan_loai = isset($_GET['phan_loai']) ? $_GET['phan_loai'] : '';
        $sap_xep = isset($_GET['sap_xep']) ? $_GET['sap_xep'] : '';
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        $brand_selected = isset($_GET['nxb']) ? $_GET['nxb'] : [];
        $chat_lieu = isset($_GET['chat_lieu']) ? $_GET['chat_lieu'] : '';
        $phien_ban = isset($_GET['phien_ban']) ? $_GET['phien_ban'] : '';

        // XỬ LÝ KHOẢNG GIÁ
        $khoang_gia = isset($_GET['khoang_gia']) ? $_GET['khoang_gia'] : '';
        $gia_min = 0;
        $gia_max = 0;
        if ($khoang_gia == 'duoi_100') {
            $gia_max = 100000;
        } elseif ($khoang_gia == '100_300') {
            $gia_min = 100000;
            $gia_max = 300000;
        } elseif ($khoang_gia == 'tren_300') {
            $gia_min = 300000;
        }

        // LOGIC PHÂN TRANG
        $limit = 12; 
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($current_page < 1) $current_page = 1;
        $offset = ($current_page - 1) * $limit;

        $total_products = $product_model->count_loc_san_pham($ma_danhmuc, $phan_loai, $brand_selected, $chat_lieu, $phien_ban, $keyword, $sap_xep, $gia_min, $gia_max);
        $total_pages = ceil($total_products / $limit);

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

        $list_brand = $brand_model->getAll(); 
        $list_phanloai = $product_model->getAll_phanloai();
        $list_dd_sp_chatlieu = $dd_sp->getAll_groupby_chatlieu();
        $list_dd_sp_phienban = $dd_sp->getAll_groupby_phien_ban();
        
        $list_product = $product_model->loc_san_pham($ma_danhmuc, $phan_loai, $sap_xep, $brand_selected, $chat_lieu, $phien_ban, $keyword, $limit, $offset, $gia_min, $gia_max);

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
            'khoang_gia' => $khoang_gia, // Truyền biến ra view
            'list_brand' => $list_brand,
            'list_phanloai' => $list_phanloai,
            'list_dd_sp_chatlieu' => $list_dd_sp_chatlieu,
            'list_dd_sp_phienban' => $list_dd_sp_phienban,
            'list_product' => $list_product,
            'total_pages' => $total_pages,
            'current_page' => $current_page,
            'total_products' => $total_products
        ];

        $this->view('user/shop/category', $data);
    }
}
?>