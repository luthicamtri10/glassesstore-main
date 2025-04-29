<?php

use App\Bus\Auth_BUS;
use App\Bus\CTGH_BUS;
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
// Route::get('/', function() {
//     // session_start();
//     $sanPham = app(SanPham_BUS::class);
//     $lsp = app(LoaiSanPham_BUS::class);
//     $hang = app(Hang_BUS::class);
//     $listSP = $sanPham->getAllModelsActive();
//     $listLSP = $lsp->getAllModels();
//     $listHang = $hang->getAllModels();
//     $top4Product = $sanPham->getTop4ProductWasHigestSale();
//     if (isset($_GET['keyword']) || !empty($_GET['keyword'])) {
//         $keyword = $_GET['keyword'];
//         $listSP = $sanPham->searchModel($keyword, []);
//     } elseif (isset($_GET['lsp']) || !empty($_GET['lsp'])) {
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
//     } else if ((isset($_GET['hang']) || !empty($_GET['hang'])) && isset($_GET['lsp']) || !empty($_GET['lsp'])) {
//         $lsp = $_GET['lsp'];
//         $hang = $_GET['hang'];
//         $listSP = $sanPham->searchByLSPAndHang($lsp,$hang);
//     }

//     $current_page = request()->query('page', 1);
//     $limit = 8;
//     $total_record = count($listSP ?? []);
//     $total_page = ceil($total_record / $limit);
//     $current_page = max(1, min($current_page, $total_page));
//     $start = ($current_page - 1) * $limit;
//     if(empty($listSP)) {
//         $tmp = [];
//     } else {
//         $tmp = array_slice($listSP, $start, $limit);
//     }
//     $isLogin = app(Auth_BUS::class)->isAuthenticated();
//     $email = app(Auth_BUS::class)->getEmailFromToken();
//     $user = app(TaiKhoan_BUS::class)->getModelById($email);
    
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
//         'sanPham' => $sanPham
//     ]);
// }); 
// Route::view('/index', 'client.index'); 
Route::get('/', function() {
    return redirect('/index' );
});
Route::get('/index', function() {
    $sanPham = app(SanPham_BUS::class);
    $lsp = app(LoaiSanPham_BUS::class);
    $hang = app(Hang_BUS::class);
    
    // Lấy danh sách sản phẩm
    $listSP = $sanPham->getAllModelsActive();
    $listLSP = $lsp->getAllModels();
    $listHang = $hang->getAllModels();
    $top4Product = $sanPham->getTop4ProductWasHigestSale();

    // Xử lý các tham số tìm kiếm
    // if (request()->has('keyword')) {
    //     $keyword = request('keyword');
    //     $listSP = $sanPham->searchModel($keyword, []);
    // } elseif (request()->has('lsp')) {
    //     $lspValue = request('lsp');
    //     $listSP = $lspValue == 0 ? $sanPham->getAllModels() : $sanPham->searchByLoaiSanPham($lspValue);
    // } elseif (request()->has('hang')) {
    //     $hangValue = request('hang');
    //     $listSP = $hangValue == 0 ? $sanPham->getAllModels() : $sanPham->searchByHang($hangValue);
    // } elseif (request()->has(['hang', 'lsp'])) {
    //     $lspValue = request('lsp');
    //     $hangValue = request('hang');
    //     $listSP = $sanPham->searchByLSPAndHang($lspValue, $hangValue);
    // }
    if (isset($_GET['keyword']) || !empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $listSP = $sanPham->searchModel($keyword, []);
        } elseif (isset($_GET['lsp']) || !empty($_GET['lsp'])) {
        $lsp = $_GET['lsp'];
        if ($lsp == 0) {
        $listSP = $sanPham->getAllModels();
        } else {
        $listSP = $sanPham->searchByLoaiSanPham($lsp);
        }
        } else if (isset($_GET['hang']) || !empty($_GET['hang'])) {
        $hang = $_GET['hang'];
        if ($hang == 0) {
        $listSP = $sanPham->getAllModels();
        } else {
        $listSP = $sanPham->searchByHang($hang);
        }
        } else if ((isset($_GET['hang']) || !empty($_GET['hang'])) && isset($_GET['lsp']) || !empty($_GET['lsp'])) {
        $lsp = $_GET['lsp'];
        $hang = $_GET['hang'];
        $listSP = $sanPham->searchByLSPAndHang($lsp,$hang);
        }

    // Phân trang
    $current_page = request()->query('page', 1);
    $limit = 8;
    $total_record = count($listSP ?? []);
    $total_page = ceil($total_record / $limit);
    $current_page = max(1, min($current_page, $total_page));
    $start = ($current_page - 1) * $limit;
    $tmp = empty($listSP) ? [] : array_slice($listSP, $start, $limit);
    
    // Kiểm tra đăng nhập
    $isLogin = app(Auth_BUS::class)->isAuthenticated();
    $email = app(Auth_BUS::class)->getEmailFromToken();
    $user = app(TaiKhoan_BUS::class)->getModelById($email);
    
    // Trả về view
    return view('client.index', [
        'listSP' => $listSP,
        'listLSP' => $listLSP,
        'listHang' => $listHang,
        'tmp' => $tmp,
        'current_page' => $current_page,
        'total_page' => $total_page,
        'isLogin' => $isLogin,
        'user' => $user,
        'top4Product' => $top4Product,
        'sanPham' => $sanPham
    ]);
});
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
Route::view('/admin', 'layout.admin');

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
// Route::get('/yourcart/search', [GioHangController::class, 'search'])->name('cart.search');
?>
