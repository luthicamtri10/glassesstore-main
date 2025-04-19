<?php

use App\Bus\Auth_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Dao\LoaiSanPham_DAO;
use App\Bus\Tinh_BUS;
use App\Enum\GioiTinhEnum;
use App\Models\GioHang;
use App\Models\Hang;
use App\Models\LoaiSanPham;
use App\Models\NguoiDung;
use App\Models\Quyen;
use App\Models\SanPham;
use App\Models\TaiKhoan;
use App\Utils\JWTUtils;
use Illuminate\Support\Facades\Auth;

   // $isLogin = app(Auth_BUS::class)->isAuthenticated();
   // echo "Token: " .var_dump($isLogin) . '<br>';
   // app(Auth_BUS::class)->logout();
   // $list = app(SanPham_BUS::class)->getTop4ProductWasHigestSale();
   // foreach($list as $it) {
   //    echo $it->getTenSanPham() . '<br>';
   // } 
   // echo app(SanPham_BUS::class)->getStock(1);
   echo 'tinh: ',app(Tinh_BUS::class)->getModelById(2)->getTenTinh().'<br>';
   $nd = new NguoiDung(null,'test','2025-04-01',GioiTinhEnum::MALE,'Đường Phú Minh, Hà Nội',app(Tinh_BUS::class)->getModelById(2),'000000000000000','015632897459',1);
   var_dump($nd);
   echo 'add nd: ', app(NguoiDung_BUS::class)->addModel($nd);
   // $tk = new TaiKhoan('khang','please@gmail.com','123456789',$nd,app(Quyen_BUS::class)->getModelById(3), 1);
   // echo app(TaiKhoan_BUS::class)->addModel($tk);

?>