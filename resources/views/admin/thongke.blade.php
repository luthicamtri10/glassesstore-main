<?php

use App\Bus\Auth_BUS;
use App\Bus\ChucNang_BUS;
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
use App\Bus\NCC_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PhieuNhap_BUS;
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
use App\Http\Controllers\CTPNController;
use App\Models\CTGH;
use App\Models\CTPN;
use App\Models\CTQ;
use App\Models\CTSP;
use App\Models\GioHang;
use App\Models\Hang;
use App\Models\LoaiSanPham;
use App\Models\ChucNang;
use App\Dao\CTQ_DAO;
use App\Enum\HoaDonEnum;
use App\Models\NguoiDung;
use App\Models\PhieuNhap;
use App\Models\Quyen;
use App\Models\SanPham;
use App\Models\TaiKhoan;
use App\Utils\JWTUtils;
use Illuminate\Support\Facades\Auth;
   // $list = app(CTPN_BUS::class)->getByPhieuNhapId(1);
   // foreach($list as $it) {
   //    echo $it->getIdSP()->getTenSanPham() .'<br>';
   // }
   // // $pn = app(PhieuNhap_BUS::class)->getModelById(1);
   // // echo $pn->getTongTien().'<br>';
   // // $sp = app(SanPham_BUS::class)->getModelById(1);
   // // echo $sp->getTenSanPham().'<br>';
//    $list = app(CTPNController::class)->getByPhieuNhapId(1);
//    foreach($list as $it) {
//       echo 'Tên sản phẩm: ' . $it['tenSanPham'] . '<br>'; // In tên sản phẩm
//       echo 'Số lượng: ' . $it['soLuong'] . '<br>'; // In số lượng
//       echo 'Đơn giá: ' . $it['donGia'] . '<br>'; // In đơn giá
//       echo '<hr>'; // Ngăn cách giữa các sản phẩm
//   }
   // $list = app(PhieuNhap_BUS::class)->searchModel('1', []);
   // foreach($list as $it) {
   //    echo $it->getTongTien() .'<br>';
   // }
   // $ncc_id = app(NCC_BUS::class)->getModelById(2);
   // echo $ncc_id->getTenNCC() .'<br>';
   // $sp = app(SanPham_BUS::class)->getModelById(3);
   // echo $sp->getTenSanPham() .'<br>';
   // $email = app(Auth_BUS::class)->getEmailFromToken();
   // $tk = app(TaiKhoan_BUS::class)->getModelById($email);
   // $nv = $tk->getIdNguoiDung();
   // // $pn = app(PhieuNhap_BUS::class)->getModelById(3);
   // $pn = new PhieuNhap(null, $ncc_id, null, '2023-11-23',$nv,1);
   // $last = app(PhieuNhap_BUS::class)->getLastPN();
   // // var_dump($last);
   // echo "Lastest PN: ". $last->getIdNCC()->getTenNCC() .'<br>';
   // if(app(PhieuNhap_BUS::class)->addModel($pn)) {
   //    echo 'SUCCESS!' .'<br>';
   // } else {
   //    echo 'FAILED!' .'<br>';
   // }
   // echo app(PhieuNhap_BUS::class)->addModel($pn) .'<br>';
   // $ctpn = new CTPN($pn, $sp, 1, 0.12, 1111111,1);
   // if(app(CTPN_BUS::class)->addModel($ctpn)) {
   //    echo 'SUCCESS!' .'<br>';
   // } else {
   //    echo 'FAILED!' .'<br>';
   // }
   // Tạo đối tượng Quyen và ChucNang mẫu (giả sử đã có quyền ID=1, chức năng ID=2)
// $quyen = app(Quyen_BUS::class)->getModelById(7);
// $chucNang = app(ChucNang_BUS::class)->getModelById(1);
// echo $quyen->getTenQuyen().'<br>';
// echo $chucNang->getTenChucNang().'<br>';
// // // Tạo đối tượng CTQ
// $ctq = new CTQ($quyen, $chucNang, 1);

// // // Gọi hàm insert
// // $ctqDAO = app(CTQ_DAO::class);
// $result = app(CTQ_BUS::class)->addModel($ctq);

// // In ra kết quả
// echo 'Kết quả insert CTQ: ' . $result . '<br>';
   // $email = app(Auth_BUS::class)->getEmailFromToken();
   // $user = app(TaiKhoan_BUS::class)->getModelById($email);
   // dd(HoaDonEnum::PAID);
   $sp = app(HoaDon_BUS::class)->getHoaDonsByTrangThai(HoaDonEnum::PAID->value);

   dd($sp);

?>