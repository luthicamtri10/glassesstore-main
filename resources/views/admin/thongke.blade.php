<?php


// use App\Bus\TaiKhoan_BUS;

use App\Bus\TaiKhoan_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PhieuNhap_BUS;
use App\Bus\GioHang_BUS;
use App\Models\GioHang;
use App\Models\NguoiDung;
use App\Models\PhieuNhap;
use App\Models\TaiKhoan;

//  $nccmodel = app(TaiKhoan_BUS::class)->getModelById("trilu@gmail.com");
// $ndmodel = app(GioHang_BUS::class)->getAllModels();

// $pnmodel = new GioHang(2,$nccmodel,'2025-04-18',1);
// $pnmodel = app(PhieuNhap_BUS::class)->getModelById(5);

// echo $pnmodel->getTaiKhoan()->getEmail();
$new = app(GioHang_BUS::class)->getModelById(1);
// echo $new;
//    $list = app(NguoiDung_BUS::class)->getAllModels();
   // foreach($ndmodel as $it) {
      echo $new->getTaiKhoan()->getEmail() . '<br>';
   // }

?>
<!-- <h1>HELLO</h1> -->