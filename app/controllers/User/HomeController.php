<?php

class HomeController extends Controller {
    
    public function index() {
        $categoryModel = $this->model('Category');
        $list_ct = $categoryModel->getAll_dm();
        $data = [
            'title' => 'Chapter One - The Beginning',
            'list_ct' => $list_ct,
        ];
        $this->view('user/home/index', $data);
    }
    public function gioithieu() {
        $data = [
            'title' => 'Chapter One - The Beginning',
        ];
        $this->view('user/home/gioithieu', $data);
    }
    public function tintuc() {
    $couponModel = $this->model('Coupon');
    $list_coupons = $couponModel->getActiveCoupons();

    $data = [
        'title' => 'Ưu Đãi & Khuyến Mãi - Chapter One',
        'list_coupons' => $list_coupons
    ];
    $this->view('user/home/tintuc', $data);
}
    public function lienhe() {
        $data = [
            'title' => 'Chapter One - The Beginning',
        ];
        $this->view('user/home/lienhe', $data);
    }
    
}
?>