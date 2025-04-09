<?php

use App\Bus\Auth_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Enum\GioiTinhEnum;
use App\Models\GioHang;
use App\Models\NguoiDung;
use App\Models\Quyen;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\Auth;

   $list = app(NguoiDung_BUS::class)->getAllModels();
   foreach($list as $it) {
    echo $it->getHoTen() . '<br>';
   }
?>