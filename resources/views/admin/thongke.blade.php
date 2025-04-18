<?php

use App\Bus\Auth_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Enum\GioiTinhEnum;
use App\Models\GioHang;
use App\Models\Hang;
use App\Models\NguoiDung;
use App\Models\Quyen;
use App\Models\TaiKhoan;
use App\Utils\JWTUtils;
use Illuminate\Support\Facades\Auth;
use App\Bus\CPVC_BUS;
use App\Bus\NCC_BUS;

   $list = app(NCC_BUS::class)->getAllModels();
   foreach($list as $it) {
    echo $it->getMoTa(). '<br>';
   }
   // $it = app(SanPham_BUS::class)->getModelById(1);
   // echo $it->gettenLSP(). '<br>';
   // session_start();
   // app(Auth_BUS::class)->login("admin@example.com","12345");
   //  $isLogin = app(Auth_BUS::class)->isAuthenticated();
   //  echo "Token: " .var_dump($isLogin) . '<br>';
   //  $email = app(Auth_BUS::class)->getEmailFromToken();
   //  $user = app(TaiKhoan_BUS::class)->getModelById($email);
   //  echo 'isLogin '.$isLogin . '<br>';
   //  echo 'email '. $email . '<br>';
   //  echo 'user '. var_dump($user);
   // $decoded = app(JWTUtils::class)::verifyToken($_SESSION['token']);
   // echo '<pre>';
   // print_r($decoded);
   // echo '</pre>';
   app(Auth_BUS::class)->logout();
   
?>