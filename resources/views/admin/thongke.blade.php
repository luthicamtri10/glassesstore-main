<?php

use App\Bus\GioHang_BUS;
use App\Bus\NCC_BUS;
use App\Bus\NguoiDung_BUS;

use App\Bus\PhieuNhap_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Models\GioHang;
use App\Models\PhieuNhap;

   // $ncc = app(NCC_BUS::class)->getModelById(1);
   $nd = app(TaiKhoan_BUS::class)->getModelById('thaozy@gmail.com');
   // echo $ncc->getTenNCC() . '<br>';
   $pnMd = new GioHang(0,$nd,'2025-04-30',1);
   // echo $pnMd->getId() . '<br>';
   app(GioHang_BUS::class)->addModel($pnMd);
   // $list = app(GioHang_BUS::class)->getModelById(2);
   // dd(app(PhieuNhap_BUS::class));

   // foreach($list as $it) {
      // echo $list->getTaiKhoan()->getTenTK() . '<br>';
   // }

?>
