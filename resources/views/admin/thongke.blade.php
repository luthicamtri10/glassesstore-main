<?php

use App\Bus\Auth_BUS;
use App\Bus\CTGH_BUS;
use App\Bus\CTHD_BUS;
use App\Bus\CTPN_BUS;
use App\Bus\CTQ_BUS;
use App\Bus\CTSP_BUS;
use App\Bus\DVVC_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\HoaDon_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PTTT_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Dao\LoaiSanPham_DAO;
use App\Bus\Tinh_BUS;
use App\Dao\CTGH_DAO;
use App\Dao\CTPN_DAO;
use App\Dao\CTSP_DAO;
use App\Dao\DVVC_DAO;
use App\Dao\SanPham_DAO;
use App\Enum\GioiTinhEnum;
use App\Models\CTGH;
use App\Models\CTPN;
use App\Models\CTQ;
use App\Models\CTSP;
use App\Models\GioHang;
use App\Models\Hang;
use App\Models\LoaiSanPham;
use App\Models\NguoiDung;
use App\Models\Quyen;
use App\Models\SanPham;
use App\Models\TaiKhoan;
use App\Utils\JWTUtils;
use Illuminate\Support\Facades\Auth;
   $dvvc = app(DVVC_BUS::class)->getModelById(3);
   echo $dvvc->getTenDV() .'-'. $dvvc->getIdDVVC() .'-'. $dvvc->getMoTa() .'-'. $dvvc->getTrangThaiHD() . '<br>';
   $dvvc->setTenDV('hihihi');
   if(app(DVVC_BUS::class)->updateModel($dvvc)) {
      echo 'success! <br>';
   } else {
      echo 'failed! <br>';
   }
   $dvvc = app(DVVC_BUS::class)->getModelById(3);
   // echo $dvvc->getTenDV() . '<br>';
   echo $dvvc->getTenDV() .'-'. $dvvc->getIdDVVC() .'-'. $dvvc->getMoTa() .'-'. $dvvc->getTrangThaiHD() . '<br>';

?>