<?php

use App\Bus\ChiTietBaoHanh_BUS;
use App\Bus\CTGH_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\NCC_BUS;
use App\Bus\NguoiDung_BUS;

use App\Bus\PhieuNhap_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Models\GioHang;
use App\Models\PhieuNhap;

   $sp = app(ChiTietBaoHanh_BUS::class)->getAllModels();
   // dd($sp);

   // $nd = app(TaiKhoan_BUS::class)->getModelById('thaozy@gmail.com');
   // echo $ncc->getTenNCC() . '<br>';
   // $pnMd = new GioHang(0,$nd,'2025-04-30',1);
   // echo $pnMd->getId() . '<br>';
   // app(GioHang_BUS::class)->addModel($pnMd);
   // $list = app(CTGH_BUS::class)->getByIDGH(1);
   // dd(app(PhieuNhap_BUS::class));

   // foreach($list as $it) {
   //    echo $it->getSP()->getId() . '<br>';
   // }

?>
