<?php

use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Enum\GioiTinhEnum;
use App\Models\GioHang;
use App\Models\NguoiDung;
use App\Models\TaiKhoan;
   $list = app(GioHang_BUS::class)->getByEmail("holobinhinh@gmail.com");
   foreach($list as $it) {
        echo $it->getEmail() . '<br>';
   }
    $tk = app(TaiKhoan_BUS::class)->getModelById("holobinhinh@gmail.com");
    echo $tk->getEmail() .'<br>';
    echo app(TaiKhoan_BUS::class)->controlDeleteModel("holobinhinh@gmail.com", 0);

?>