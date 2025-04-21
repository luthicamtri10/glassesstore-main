<?php

use App\Bus\Auth_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Http\Controllers\NguoiDungController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\NccController;
use App\Http\Controllers\DonViVanChuyenController;
use App\Http\Controllers\PhieuNhapController;
use App\Bus\CPVC_BUS;
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
        'user' => $user
    ]);
}); 
Route::view('/index', 'client.index'); 
Route::view('/login', 'client.Login-Register');
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
        'nguoidung' => $nguoidung
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

Route::post('/admin/donvivanchuyen/store', [DonViVanChuyenController::class, 'store'])->name('admin.donvivanchuyen.store');
Route::post('/admin/donvivanchuyen/update', [DonViVanChuyenController::class, 'update'])->name('admin.donvivanchuyen.update');
Route::post('/admin/donvivanchuyen/controldelete', [DonViVanChuyenController::class, 'controlDelete'])->name('admin.donvivanchuyen.controlDelete');


Route::post('/admin/nhacungcap/controldelete', [NccController::class, 'controlDelete'])->name('admin.nhacungcap.controlDelete');
Route::post('/admin/nhacungcap/store', [NccController::class, 'store'])->name('admin.nhacungcap.store');
Route::post('/admin/nhacungcap/update', [NccController::class, 'update'])->name('admin.nhacungcap.update');

Route::post('/admin/chiphivanchuyen/store', [CPVC_BUS::class, 'store'])->name('admin.chiphivanchuyen.store');
Route::post('/admin/chiphivanchuyen/update', [CPVC_BUS::class, 'update'])->name('admin.chiphivanchuyen.update');
Route::post('/admin/chiphivanchuyen/controldelete', [CPVC_BUS::class, 'controlDelete'])->name('admin.chiphivanchuyen.controlDelete');

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
// Route::post('/chechExistingUserBySDT', function (Request $request) {
//     $sdt = $request->query('sdt');
//     $nd = app(NguoiDung_BUS::class)->getModelBySDT($sdt);

//     if ($nd != null) {
//         return response()->json([
//             'exists' => true,
//             'data' => [
//                 'ho_ten' => $nd->getHoTen(),
//                 'gioi_tinh' => $nd->getGioiTinh(),
//                 'ngay_sinh' => $nd->getNgaySinh(),
//                 'dia_chi' => $nd->getDiaChi(),
//                 'tinh' => $nd->getTinh()->getTenTinh(), // ví dụ: Tinh cũng là object, phải gọi getter
//                 'sodienthoai' => $nd->getSoDienThoai(),
//                 'cccd' => $nd->getCccd()
//             ]
//         ]);
//     } else {
//         return response()->json([
//             'exists' => false,
//         ]);
//     }
// })->name('chechExistingUserBySDT');

// Routes for transport management
Route::prefix('admin')->group(function () {
    Route::get('/transport', [DonViVanChuyenController::class, 'index'])->name('admin.transport.index');
    Route::post('/transport', [DonViVanChuyenController::class, 'store'])->name('admin.transport.store');
    Route::put('/transport/{id}', [DonViVanChuyenController::class, 'update'])->name('admin.transport.update');
    Route::delete('/transport/{id}', [DonViVanChuyenController::class, 'destroy'])->name('admin.transport.destroy');

    // Supplier routes
    Route::get('/supplier', [NccController::class, 'index'])->name('admin.supplier.index');
    Route::post('/supplier', [NccController::class, 'store'])->name('admin.supplier.store');
    Route::put('/supplier/{id}', [NccController::class, 'update'])->name('admin.supplier.update');
    Route::delete('/supplier/{id}', [NccController::class, 'destroy'])->name('admin.supplier.destroy');
    Route::get('/supplier/search', [NccController::class, 'search'])->name('admin.supplier.search');
});

// Routes for shipping cost management
Route::prefix('admin')->group(function () {
    Route::get('/shipping-cost', function() {
        $shippingCostBUS = app(\App\Bus\CPVC_BUS::class);
            
        $listShippingCost = $shippingCostBUS->getAllModels();
        return view('admin.chiphivanchuyen', [
            'listShippingCost' => $listShippingCost ?? []
        ]);
    })->name('admin.shipping-cost.index');
    // Thêm chi phí vận chuyển
    Route::post('/shipping-cost/store', function(Request $request) {
        $shippingCostBUS = app(\App\Bus\CPVC_BUS::class);
        $shippingCostBUS->addModel([
            'IDTINH' => $request->input('id_tinh'),
            'IDVC' => $request->input('id_vc'),
            'CHIPHIVC' => $request->input('chi_phi')
        ]);
        return redirect()->route('admin.shipping-cost.index')->with('success', 'Thêm chi phí vận chuyển thành công!');
    })->name('admin.shipping-cost.store');

    // Cập nhật chi phí vận chuyển
    Route::post('/shipping-cost/update/{id}', function(Request $request, $id) {
        $shippingCostBUS = app(\App\Bus\CPVC_BUS::class);
        $shippingCostBUS->updateModel([
            'ID' => $id,
            'IDTINH' => $request->input('id_tinh'),
            'IDVC' => $request->input('id_vc'),
            'CHIPHIVC' => $request->input('chi_phi')
        ]);
        return redirect()->route('admin.shipping-cost.index')->with('success', 'Cập nhật thành công!');
    })->name('admin.shipping-cost.update');

    // Xóa chi phí vận chuyển
    Route::delete('/shipping-cost/delete/{id}', function($id) {
        $shippingCostBUS = app(\App\Bus\CPVC_BUS::class);
        $shippingCostBUS->deleteModel($id);
        return redirect()->route('admin.shipping-cost.index')->with('success', 'Xóa thành công!');
    })->name('admin.shipping-cost.delete');
    
});

// Routes for purchase order management
Route::prefix('admin')->group(function () {
    Route::get('/phieunhap', [PhieuNhapController::class, 'index'])->name('admin.phieunhap.index');
    Route::post('/phieunhap', [PhieuNhapController::class, 'store'])->name('admin.phieunhap.store');
    Route::get('/phieunhap/search', [PhieuNhapController::class, 'search'])->name('admin.phieunhap.search');
    Route::get('/phieunhap/{id}/chitiet', [PhieuNhapController::class, 'getChiTiet'])->name('admin.phieunhap.chitiet');
});

?>
