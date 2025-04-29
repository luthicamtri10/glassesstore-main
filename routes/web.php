<?php

use App\Bus\Auth_BUS;
use App\Bus\CTGH_BUS;
use App\Bus\CTQ_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\NguoiDungController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TaiKhoanController;
use App\Models\CTQ;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function() {
    return redirect('/index' );
});
// Route::get('/index', function() {
//     $sanPham = app(SanPham_BUS::class);
//     $lsp = app(LoaiSanPham_BUS::class);
//     $hang = app(Hang_BUS::class);
    
//     // Lấy danh sách sản phẩm
//     $listSP = $sanPham->getAllModelsActive();
//     $listLSP = $lsp->getAllModels();
//     $listHang = $hang->getAllModels();
//     $top4Product = $sanPham->getTop4ProductWasHigestSale();

//     if (isset($_GET['keyword']) || !empty($_GET['keyword'])) {
//         $keyword = $_GET['keyword'];
//         $listSP = $sanPham->searchModel($keyword, []);
//     } else if (isset($_GET['lsp']) || !empty($_GET['lsp'])) {
//         $lsp = $_GET['lsp'];
//         if ($lsp == 0) {
//             $listSP = $sanPham->getAllModels();
//         } else {
//             $listSP = $sanPham->searchByLoaiSanPham($lsp);
//         }
//     } else if (isset($_GET['hang']) || !empty($_GET['hang'])) {
//         $hang = $_GET['hang'];
//         if ($hang == 0) {
//             $listSP = $sanPham->getAllModels();
//         } else {
//             $listSP = $sanPham->searchByHang($hang);
//         }
//     } else if (isset($_GET['khoanggia']) || !empty($_GET['khoanggia'])) {
//         $khoanggia = $_GET['khoanggia'];
//         if($khoanggia == 0) {
//             $listSP = $sanPham->getAllModels();
//         } else {
//             // Tách startPrice và endPrice
//             $khoanggia = trim($khoanggia, '[]'); // Loại bỏ dấu ngoặc vuông
//             list($startPrice, $endPrice) = explode('-', $khoanggia);
            
//             // Kiểm tra nếu endPrice là '...'
//             if ($endPrice === '...') {
//                 $endPrice = 1000000000; // Gán giá trị lớn cho endPrice
//             } else {
//                 $endPrice = (float)$endPrice; // Chuyển đổi sang kiểu số nếu không phải là '...'
//             }
            
//             $startPrice = (float)$startPrice; // Chuyển đổi sang kiểu số
            
//             // Gọi hàm tìm kiếm theo khoảng giá
//             $listSP = $sanPham->searchByKhoangGia($startPrice, $endPrice);
//         }
//     } else if ((isset($_GET['hang']) || !empty($_GET['hang'])) && isset($_GET['lsp']) || !empty($_GET['lsp'])) {
//         $lsp = $_GET['lsp'];
//         $hang = $_GET['hang'];
//         if($lsp == 0) {
//             $listSP = $sanPham->searchByHang($hang);
//         } else if ($hang == 0) {
//             $listSP = $sanPham->searchByLoaiSanPham($lsp);
//         } else if ($lsp == 0 && $hang == 0){
//             $listSP = $sanPham->getAllModels();
//         }
//         $listSP = $sanPham->searchByLSPAndHang($lsp,$hang);
//     } else if ((isset($_GET['keyword']) || !empty($_GET['keyword'])) && (isset($_GET['khoanggia']) || !empty($_GET['khoanggia'])) && (isset($_GET['lsp']) || !empty($_GET['lsp']))) {
//         // searchByKhoangGiaAndHangAndModel($keyword,$idlsp,$startprice,$endprice)
//         $lsp = $_GET['lsp'];
//         $keyword = $_GET['keyword'];
//         $khoanggia = $_GET['khoanggia'];
//         $khoanggia = trim($khoanggia, '[]'); // Loại bỏ dấu ngoặc vuông
//         list($startPrice, $endPrice) = explode('-', $khoanggia);
        
//         // Kiểm tra nếu endPrice là '...'
//         if ($endPrice === '...') {
//             $endPrice = 1000000000; // Gán giá trị lớn cho endPrice
//         } else {
//             $endPrice = (float)$endPrice; // Chuyển đổi sang kiểu số nếu không phải là '...'
//         }
        
//         $startPrice = (float)$startPrice; // Chuyển đổi sang kiểu số
//         if ($lsp == 0 && $khoanggia == 0) {
//             $listSP = $sanPham->searchModel($keyword, []);
//         }
//         if($khoanggia == 0) {
//             $listSP = $sanPham->searchByLSPAndModel($keyword,$lsp);
//         }
//         if($lsp == 0) {
//             $listSP = $sanPham->searchByKhoangGiaAndModel($keyword,$startPrice,$endPrice);
//         }
//         $listSP = $sanPham->searchByKhoangGiaAndLSPAndModel($keyword,$lsp,$startPrice,$endPrice);
//     }

//     // Phân trang
//     $current_page = request()->query('page', 1);
//     $limit = 8;
//     $total_record = count($listSP ?? []);
//     $total_page = ceil($total_record / $limit);
//     $current_page = max(1, min($current_page, $total_page));
//     $start = ($current_page - 1) * $limit;
//     $tmp = empty($listSP) ? [] : array_slice($listSP, $start, $limit);
    
//     // Kiểm tra đăng nhập
//     $isLogin = app(Auth_BUS::class)->isAuthenticated();
//     $email = app(Auth_BUS::class)->getEmailFromToken();
//     $user = app(TaiKhoan_BUS::class)->getModelById($email);
//     // $ctq = app(CTQ_BUS::class)->getModelById($user->getIdQuyen()->getId());
    
//     // Trả về view
//     return view('client.index', [
//         'listSP' => $listSP,
//         'listLSP' => $listLSP,
//         'listHang' => $listHang,
//         'tmp' => $tmp,
//         'current_page' => $current_page,
//         'total_page' => $total_page,
//         'isLogin' => $isLogin,
//         'user' => $user,
//         'top4Product' => $top4Product,
//         'sanPham' => $sanPham,
//         // 'ctq' => $ctq
//     ]);
// });
Route::get('/index', function() {
    $sanPham = app(SanPham_BUS::class);
    $lsp = app(LoaiSanPham_BUS::class);
    $hang = app(Hang_BUS::class);

    // Lấy danh sách sản phẩm
    $listSP = $sanPham->getAllModelsActive();
    $listLSP = $lsp->getAllModels();
    $listHang = $hang->getAllModels();
    $top4Product = $sanPham->getTop4ProductWasHigestSale();

    $keyword = $_GET['keyword'] ?? null;
    $idLSP = $_GET['lsp'] ?? null;
    $idHang = $_GET['hang'] ?? null;
    $khoanggia = $_GET['khoanggia'] ?? null;

    // Khởi tạo danh sách sản phẩm
    $filteredSP = $listSP;

    // Lọc theo keyword
    if ($keyword) {
        $filteredSP = $sanPham->searchModel($keyword, []);
    }

    // Lọc theo loại sản phẩm (LSP)
    if ($idLSP && $idLSP != 0) {
        $filteredSP = $sanPham->searchByLoaiSanPham($idLSP);
    }

    // Lọc theo hãng
    if ($idHang && $idHang != 0) {
        $filteredSP = $sanPham->searchByHang($idHang);
    }

    if ($idLSP && $idHang) {
        $filteredSP = $sanPham->searchByLSPAndHang($idLSP,$idHang);
    }

    // Lọc theo khoảng giá
    if ($khoanggia && $khoanggia != 0) {
        $khoanggia = trim($khoanggia, '[]');
        list($startPrice, $endPrice) = explode('-', $khoanggia);
        if ($endPrice === '...') {
            $endPrice = 1000000000;
        }
        $startPrice = (float)$startPrice;
        $endPrice = (float)$endPrice;

        $filteredSP = $sanPham->searchByKhoangGia($startPrice, $endPrice);
    }

    // Kết hợp các điều kiện lọc
    if ($keyword && $idLSP && $khoanggia) {
        $filteredSP = $sanPham->searchByKhoangGiaAndLSPAndModel($keyword, $idLSP, $startPrice, $endPrice);
    } elseif ($keyword && $idLSP) {
        $filteredSP = $sanPham->searchByLSPAndModel($keyword, $idLSP);
    } elseif ($keyword && $khoanggia) {
        $filteredSP = $sanPham->searchByKhoangGiaAndModel($keyword, $startPrice, $endPrice);
    } elseif ($idLSP && $khoanggia) {
        $filteredSP = $sanPham->searchByKhoangGiaAndLSP($idLSP, $startPrice, $endPrice);
    }

    // Phân trang
    $current_page = request()->query('page', 1);
    $limit = 8;
    $total_record = count($filteredSP ?? []);
    $total_page = ceil($total_record / $limit);
    $current_page = max(1, min($current_page, $total_page));
    $start = ($current_page - 1) * $limit;
    $tmp = empty($filteredSP) ? [] : array_slice($filteredSP, $start, $limit);

    // Kiểm tra đăng nhập
    $isLogin = app(Auth_BUS::class)->isAuthenticated();
    $email = app(Auth_BUS::class)->getEmailFromToken();
    $user = app(TaiKhoan_BUS::class)->getModelById($email);
    $gh = app(GioHang_BUS::class)->getByEmail($email);
    // $ctq = app(CTQ_BUS::class)->getModelById($user->getIdQuyen()->getId());
    // Trả về view
    $products = array_map(function($sp) {
        return [
            'id' => $sp->getId(),
            'tenSanPham' => $sp->getTenSanPham(),
            'moTa' => $sp->getMoTa(),
            'donGia' => number_format($sp->getDonGia(), 0, ',', '.'),
            'thoiGianBaoHanh' => $sp->getThoiGianBaoHanh(),
            'img' => "productImg/{$sp->getId()}.webp", // Đường dẫn hình ảnh
            'hang' => $sp->getIdHang()->getTenHang(), // Tên hãng
            'lsp' => $sp->getIdLSP()->getTenLSP() // Tên loại sản phẩm
        ];
    }, $filteredSP);
    return view('client.index', [
        'listSP' => $filteredSP,
        'listLSP' => $listLSP,
        'listHang' => $listHang,
        'tmp' => $tmp,
        'current_page' => $current_page,
        'total_page' => $total_page,
        'isLogin' => $isLogin,
        'user' => $user,
        'top4Product' => $top4Product,
        'sanPham' => $sanPham,
        'gh' => $gh
    ]);
});
Route::view('/admin', 'layout.admin')->middleware('admin.access');
Route::view('/login', 'client.Login-Register');
Route::get('/yourcart', function() {
    $email = $_GET['email'];
    $gh = app(GioHang_BUS::class)->getByEmail($email);
    $listCTGH = app(CTGH_BUS::class)->getByIDGH($gh->getIdGH());
    if (isset($_GET['keyword']) || !empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $listCTGH = app(CTGH_BUS::class)->searchCTGHByKeyword($gh->getIdGH(), $keyword);
    }
    return view('client.userCart', ['listCTGH'=>$listCTGH]);
});
Route::get('/register', function() {
    $listTinh = app(Tinh_BUS::class)->getAllModels();
    $nguoidung = null;
    if (isset($_GET['sdt']) || !empty($_GET['sdt'])) {
        $nd = app(NguoiDung_BUS::class)->getModelBySDT($_GET['sdt']);
        if ($nd != null) {
            $nguoidung = $nd;
        } else {
            $nguoidung = null;
        }
    } 
    return view('client.Register', [
        'listTinh' => $listTinh,
    ]);
});
// Route::view('/admin', 'layout.admin');

Route::post('admin/sanpham/store', [SanPhamController::class, 'store'])->name('admin.sanpham.store');
Route::post('admin/sanpham/update', [SanPhamController::class, 'update'])->name('admin.sanpham.update');
Route::delete('admin/sanpham/delete', [SanPhamController::class, 'delete'])->name('admin.sanpham.delete');

Route::post('/admin/loaisanpham/store', [LoaiSanPhamController::class, 'store'])->name('admin.loaisanpham.store');
Route::post('/admin/loaisanpham/update', [LoaiSanPhamController::class, 'update'])->name('admin.loaisanpham.update');
Route::post('/admin/loaisanpham/delete', [LoaiSanPhamController::class, 'delete'])->name('admin.loaisanpham.delete');

Route::post('/admin/taikhoan/store', [TaiKhoanController::class, 'store'])->name('admin.taikhoan.store');
Route::post('/admin/taikhoan/update', [TaiKhoanController::class, 'update'])->name('admin.taikhoan.update');
Route::post('/admin/taikhoan/controldelete', [TaiKhoanController::class, 'controlDelete'])->name('admin.taikhoan.controlDelete');

Route::post('/admin/nguoidung/store', [NguoiDungController::class, 'store'])->name('admin.nguoidung.store');
Route::post('/admin/nguoidung/update', [NguoiDungController::class, 'update'])->name('admin.nguoidung.update');
Route::post('/admin/nguoidung/controldelete', [NguoiDungController::class, 'controlDelete'])->name('admin.nguoidung.controlDelete');

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GioHangController;

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email-login');
    $password = $request->input('password-login');
    
    $auth = app()->make(AuthController::class);
    
    if ($auth->login($email, $password)) {
        return redirect('/'); // hoặc trang dashboard nếu login thành công
    } else {
        return back()->withErrors(['login' => 'Email hoặc mật khẩu không đúng!']);
    }
})->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register/register', [AuthController::class, 'register'])->name('register.register');
Route::post('/yourcart/update', [GioHangController::class, 'updateQuantity'])->name('cart.update');
Route::post('/yourcart/delete', [GioHangController::class, 'deleteCTGH'])->name('cart.delete');
Route::post('/index/addctgh', [GioHangController::class, 'add'])->name('index.addctgh');
?>
