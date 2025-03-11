<?php

namespace App\Models;

class ChucNang
{
    private $id, $quanlisanpham, $quanlihoadon, $quanlincc, $quanliphieunhap, $quanlitaikhoan, $dathang, $thongke, $quanlikhuyenmai, $quanliquyen, $quanlidvvc, $quanlibaohanh;
    public function __construct($id, $quanlisanpham, $quanlihoadon, $quanlincc, $quanliphieunhap, $quanlitaikhoan, $dathang, $thongke, $quanlikhuyenmai, $quanliquyen, $quanlidvvc, $quanlibaohanh)
    {
        $this->id = $id;
        $this->quanlisanpham = $quanlisanpham;
        $this->quanlihoadon = $quanlihoadon;
        $this->quanlincc = $quanlincc;
        $this->quanliphieunhap = $quanliphieunhap;
        $this->quanlitaikhoan = $quanliphieunhap;
        $this->dathang = $dathang;
        $this->thongke = $thongke;
        $this->quanlikhuyenmai = $quanlikhuyenmai;
        $this->quanliquyen = $quanliquyen;
        $this->quanlidvvc = $quanlidvvc;
        $this->quanlibaohanh = $quanlibaohanh;
    }
}
