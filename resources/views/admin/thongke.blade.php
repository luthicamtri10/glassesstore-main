<?php

use App\Bus\NCC_BUS;
use App\Bus\NguoiDung_BUS;

use App\Bus\PhieuNhap_BUS;
use App\Models\PhieuNhap;

   $ncc = app(NCC_BUS::class)->getModelById(1);
   $nd = app(NguoiDung_BUS::class)->getModelById(16);
   echo $ncc->getTenNCC() . '<br>';
   $pnMd = new PhieuNhap(3,$ncc,264263,'2451517',$nd,1);
   echo $pnMd->getId() . '<br>';
   $list = app(PhieuNhap_BUS::class)->getAllModels();
   // dd(app(PhieuNhap_BUS::class));

   foreach($list as $it) {
      echo $it->getId() . '<br>';
   }

?>
