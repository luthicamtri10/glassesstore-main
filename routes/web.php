<?php

use App\Bus\Auth_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\ThongKe_BUS;
use App\Bus\Tinh_BUS;
use App\Http\Controllers\NguoiDungController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\ThongKeController;

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
    // session_start();
    $sanPham = app(SanPham_BUS::class);
    $lsp = app(LoaiSanPham_BUS::class);
    $hang = app(Hang_BUS::class);
    $listSP = $sanPham->getAllModelsActive();
    $listLSP = $lsp->getAllModels();
    $listHang = $hang->getAllModels();
    $top4Product = $sanPham->getTop4ProductWasHigestSale();
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

    $current_page = request()->query('page', 1);
    $limit = 8;
    $total_record = count($listSP ?? []);
    $total_page = ceil($total_record / $limit);
    $current_page = max(1, min($current_page, $total_page));
    $start = ($current_page - 1) * $limit;
    if(empty($listSP)) {
        $tmp = [];
    } else {
        $tmp = array_slice($listSP, $start, $limit);
    }
    $isLogin = app(Auth_BUS::class)->isAuthenticated();
    $email = app(Auth_BUS::class)->getEmailFromToken();
    $user = app(TaiKhoan_BUS::class)->getModelById($email);
    
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
Route::view('/index', 'client.index'); 
Route::view('/login', 'client.Login-Register');
Route::view('/yourcart', 'client.userCart');
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
Route::get('/sanpham', [SanPhamController::class, 'index'])->name('sanpham.index');
Route::post('/sanpham', [SanPhamController::class, 'store'])->name('sanpham.store');
Route::delete('/sanpham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');

Route::post('/admin/taikhoan/store', [TaiKhoanController::class, 'store'])->name('admin.taikhoan.store');
Route::post('/admin/taikhoan/update', [TaiKhoanController::class, 'update'])->name('admin.taikhoan.update');
Route::post('/admin/taikhoan/controldelete', [TaiKhoanController::class, 'controlDelete'])->name('admin.taikhoan.controlDelete');

Route::post('/admin/nguoidung/store', [NguoiDungController::class, 'store'])->name('admin.nguoidung.store');
Route::post('/admin/nguoidung/update', [NguoiDungController::class, 'update'])->name('admin.nguoidung.update');
Route::post('/admin/nguoidung/controldelete', [NguoiDungController::class, 'controlDelete'])->name('admin.nguoidung.controlDelete');

use App\Http\Controllers\AuthController;

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

Route::get('/admin/thongke', [ThongKeController::class, 'index'])->name('admin.thongke');
Route::post('/admin/thongke/top', [ThongKeController::class, 'getTopCustomers'])->name('admin.thongke.top');
Route::post('/admin/thongke/orders', [ThongKeController::class, 'getCustomerOrders'])->name('admin.thongke.orders');
Route::get('/admin/thongke/details/{orderId}', [ThongKeController::class, 'getOrderDetails'])->name('admin.thongke.details');
?>
