<?php

use App\Bus\Auth_BUS;
use App\Bus\CTGH_BUS;
use App\Bus\CTPN_BUS;
use App\Bus\CTSP_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Dao\CTGH_DAO;
use App\Dao\CTPN_DAO;
use App\Dao\CTSP_DAO;
use App\Dao\SanPham_DAO;
use App\Enum\GioiTinhEnum;
use App\Models\CTGH;
use App\Models\CTPN;
use App\Models\CTSP;
use App\Models\GioHang;
use App\Models\Hang;
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
   // echo 'tinh: ',app(Tinh_BUS::class)->getModelById(2)->getTenTinh().'<br>';
   // $nd = new NguoiDung(null,'test','2025-04-01',GioiTinhEnum::MALE,'Đường Phú Minh, Hà Nội',app(Tinh_BUS::class)->getModelById(2),'000000000000000','015632897459',1);
   // var_dump($nd);
   // echo 'add nd: ', app(NguoiDung_BUS::class)->addModel($nd);
   // $tk = new TaiKhoan('khang','please@gmail.com','123456789',$nd,app(Quyen_BUS::class)->getModelById(3), 1);
   // echo app(TaiKhoan_BUS::class)->addModel($tk);
   // echo app(CTSP_DAO::class)->getSPBySoSeri("BL001")->getTenSanPham();
   // echo app(SanPham_BUS::class)->getModelById(1)->getTenSanPham();
   // echo app(CTGH_DAO::class)->checkSP(14, 4);
   // $list = app(CTGH_DAO::class)->getByIDGH(14);
   // foreach($list as $it) {
   //    echo $it->getSoSeri() .'<br>';
   // }
   // app(CTGH_DAO::class)->deleteGH(14,"TU003");
   // echo app(CTGH_DAO::class)->deleteLessSP(14,4);
   // echo app(CTSP_DAO::class)->checkCTSPIsSold("TU002");
   // $list = app(CTSP_BUS::class)->getCTSPByIDSP(1);
   // foreach ($list as $it) {
   //    echo $it->getSoSeri() . '<br>';
   // }
   // $ctpn = new CTPN(1,3,5,"1250000","3.75");
   // $ctsp = new CTSP(app(SanPham_BUS::class)->getModelById(1),"0010001");
   // echo app(CTPN_BUS::class)->addModel($ctpn);
   // $list = app(CTPN_BUS::class)->taoCTSPTuDong(1, 5);
   // foreach ($list as $key) {
   //    echo $key->getSoSeri() .'<br>';
   // }
   // echo app(CTPN_DAO::class)->insert($ctpn);
   // echo app(CTSP_DAO::class)->insert($ctsp);
   // echo count(app(CTSP_BUS::class)->getCTSPIsNotSoldByIDSP(1));
   $list = app(SanPham_BUS::class)->searchByHang(1);
   foreach ($list as $key) {
      # code...
      echo $key->getTenSanPham() .'  '. $key->getIdHang()->gettenHang() .'<br>';
   }
?>