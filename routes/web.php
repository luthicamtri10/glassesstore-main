<?php

use App\Bus\Auth_BUS;
use App\Bus\CPVC_BUS;
use App\Bus\CTGH_BUS;
use App\Bus\CTQ_BUS;
use App\Bus\CTSP_BUS;
use App\Bus\DVVC_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\HoaDon_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PTTT_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Bus\KieuDang_BUS;
use App\Http\Controllers\CPVCController;
use App\Http\Controllers\DonViVanChuyenController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\NccController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\PhieuNhapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TaiKhoanController;
use App\Models\CTQ;
use App\Http\Controllers\QuyenController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TinhController;

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

Route::get('/index', function (Request $request) {
    $sanPham = app(SanPham_BUS::class);
    $lsp = app(LoaiSanPham_BUS::class);
    $hang = app(Hang_BUS::class);
    $kieuDang = app(KieuDang_BUS::class);

    // Lấy danh sách cơ bản
    $listSP = $sanPham->getAllModelsActive();
    $listLSP = $lsp->getAllModels();
    $listHang = $hang->getAllModels();
    $listKieuDang = $kieuDang->getAllModels();
    $top4Product = $sanPham->getTop4ProductWasHigestSale();

    // Lấy tham số từ request
    $keyword = $request->input('keyword') ?? $_GET['keyword'] ?? null;
    $idLSP = $request->input('lsp') ?? $_GET['lsp'] ?? null;
    $idHang = $request->input('hang') ?? $_GET['hang'] ?? null;
    $idKieuDang = $request->input('kieudang') ?? $_GET['kieudang'] ?? null;
    $khoanggia = $request->input('khoanggia') ?? $_GET['khoanggia'] ?? null;
    $filterPriceFrom = $request->input('filter_price_from') ?? $_GET['filter_price_from'] ?? null;
    $filterPriceTo = $request->input('filter_price_to') ?? $_GET['filter_price_to'] ?? null;

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
        $filteredSP = $sanPham->searchByLSPAndHang($idLSP, $idHang);
    }

    // Lọc theo khoảng giá
    $startPrice = null;
    $endPrice = null;
    if ($khoanggia && $khoanggia != 0) {
        $khoanggia = trim($khoanggia, '[]');
        list($startPrice, $endPrice) = explode('-', $khoanggia);
        if ($endPrice === '...') {
            $endPrice = 1000000000;
        }
        $startPrice = (float)$startPrice;
        $endPrice = (float)$endPrice;
    } elseif ($filterPriceFrom || $filterPriceTo) {
        $startPrice = $filterPriceFrom ? (float)$filterPriceFrom : 0;
        $endPrice = $filterPriceTo ? (float)$filterPriceTo : 1000000000;
    }

    // Lọc theo kiểu dáng (kieudang) - bổ sung
    if ($idKieuDang && $idKieuDang != 0) {
        $filteredSP = array_filter($filteredSP, function ($sp) use ($idKieuDang) {
            return $sp->getIdKieuDang() && $sp->getIdKieuDang()->getId() == $idKieuDang;
        });
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

    // Lọc nâng cao (sử dụng searchByCriteria)
    if ($idKieuDang || $startPrice !== null || $endPrice !== null) {
        $filteredSP = $sanPham->searchByCriteria($idHang, $idLSP, $idKieuDang, $startPrice, $endPrice);
    }

    // Chuẩn bị dữ liệu JSON
    $products = array_map(function($sp) { 
        return [
            'id' => $sp->getId(),
            'tenSanPham' => $sp->getTenSanPham(),
            'moTa' => $sp->getMoTa(),
            'donGia' => number_format($sp->getDonGia(), 0, ',', '.'),
            'thoiGianBaoHanh' => $sp->getThoiGianBaoHanh(),
            'img' => "productImg/{$sp->getId()}.webp",
            'hang' => $sp->getIdHang()->getTenHang(),
            'lsp' => $sp->getIdLSP()->getTenLSP(),
            'kieudang' => $sp->getIdKieuDang() ? $sp->getIdKieuDang()->getTenKieuDang() : 'Không xác định',
            
        ];
    }, $filteredSP);

    $headers = [
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ];

    // Trả về JSON cho AJAX hoặc render view
    if ($request->ajax()) {
        return response()->json([
            'listSP' => $products,
            'success' => true
        ], 200)->withHeaders($headers);
    }

    // Phân trang
    $current_page = $request->query('page', 1);
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
    $total = 0;
    if ($isLogin) {
        $listCTGH = app(CTGH_BUS::class)->getByIDGH($gh->getIdGH());
        foreach ($listCTGH as $ct) {
            $total += $ct->getSoLuong();
        }
    }

    // Trả về view với dữ liệu ban đầu
    return view('client.index', [
        'listSP' => $filteredSP,
        'listLSP' => $listLSP,
        'listHang' => $listHang,
        'listKieuDang' => $listKieuDang,
        'tmp' => $tmp,
        'current_page' => $current_page,
        'total_page' => $total_page,
        'isLogin' => $isLogin,
        'user' => $user,
        'top4Product' => $top4Product,
        'sanPham' => $sanPham,
        'gh' => $gh,
        'totalSPinGH' => $total,
        'initialProducts' => $products 
    ]);
});
Route::get('/index/quantri', function() {
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
    $total = 0;
    if($isLogin) {
        $listCTGH = app(CTGH_BUS::class)->getByIDGH ($gh->getIdGH());
        foreach($listCTGH as $ct) {
            $total += $ct->getSoLuong();
        }
    }
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
        'gh' => $gh,
        'totalSPinGH' => $total

    ]);
});
// Route::get('/index/quantri', function() {
//     return view('admin.index'); // view dành riêng cho quyền 1, 2
// });

Route::view('/admin', 'layout.admin')->middleware('admin.access');
Route::view('/login', 'client.Login-Register');
Route::view('/admin/login', 'admin.login')->name('admin.login');
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
Route::post('admin/sanpham/delete', [SanPhamController::class, 'delete'])->name('admin.sanpham.delete');
Route::post('admin/sanpham/check-is-sold', [SanPhamController::class, 'checkIsSold'])->name('admin.sanpham.check');
Route::post('admin/sanpham/controlActive', [SanPhamController::class, 'controlActive']);


Route::post('/admin/loaisanpham/store', [LoaiSanPhamController::class, 'store'])->name('admin.loaisanpham.store');
Route::put('/admin/loaisanpham/{id}', [LoaiSanPhamController::class, 'update'])->name('admin.loaisanpham.update');
Route::delete('/admin/loaisanpham/delete', [LoaiSanPhamController::class, 'detroy'])->name('admin.loaisanpham.delete');

Route::post('/admin/taikhoan/store', [TaiKhoanController::class, 'store'])->name('admin.taikhoan.store');
Route::post('/admin/taikhoan/update', [TaiKhoanController::class, 'update'])->name('admin.taikhoan.update');
Route::post('/admin/taikhoan/controldelete', [TaiKhoanController::class, 'controlDelete'])->name('admin.taikhoan.controlDelete');

Route::post('/admin/nguoidung/store', [NguoiDungController::class, 'store'])->name('admin.nguoidung.store');
Route::post('/admin/nguoidung/update', [NguoiDungController::class, 'update'])->name('admin.nguoidung.update');
Route::post('/admin/nguoidung/controldelete', [NguoiDungController::class, 'controlDelete'])->name('admin.nguoidung.controlDelete');

Route::post('/admin/donvivanchuyen/store', [DonViVanChuyenController::class, 'store'])->name('admin.donvivanchuyen.store');
Route::post('/admin/donvivanchuyen/update', [DonViVanChuyenController::class, 'update'])->name('admin.donvivanchuyen.update');
Route::post('/admin/donvivanchuyen/controldelete', [DonViVanChuyenController::class, 'controlDelete'])->name('admin.donvivanchuyen.controlDelete');

Route::prefix('admin')->group(function () {
    Route::get('/phieunhap', [PhieuNhapController::class, 'index'])->name('admin.phieunhap.index');
    Route::post('/phieunhap', [PhieuNhapController::class, 'store'])->name('admin.phieunhap.store');
    Route::get('/phieunhap/search', [PhieuNhapController::class, 'search'])->name('admin.phieunhap.search');
    Route::get('/phieunhap/{id}/chitiet', [PhieuNhapController::class, 'getChiTiet'])->name('admin.phieunhap.chitiet');
    
    // Supplier (Nhà cung cấp) routes
    Route::post('/nhacungcap/store', [NccController::class, 'store'])->name('admin.nhacungcap.store');
    Route::post('/nhacungcap/update', [NccController::class, 'update'])->name('admin.nhacungcap.update');
    Route::post('/nhacungcap/destroy', [NccController::class, 'destroy'])->name('admin.nhacungcap.destroy');
    Route::get('/nhacungcap/search', [NccController::class, 'search'])->name('admin.nhacungcap.search');
});

Route::post('/admin/chiphivanchuyen/store', [CPVCController::class, 'store'])->name('admin.chiphivanchuyen.store');
Route::post('/admin/chiphivanchuyen/update', [CPVCController::class, 'update'])->name('admin.chiphivanchuyen.update');
Route::post('/admin/chiphivanchuyen/controldelete', [CPVCController::class, 'controlDelete'])->name('admin.chiphivanchuyen.controlDelete');

use App\Http\Controllers\HangController;
use App\Http\Controllers\KhuyenMaiController;
Route::post('/admin/hang/store', [HangController::class, 'store'])->name('admin.hang.store');
Route::post('/admin/hang/update', [HangController::class, 'update'])->name('admin.hang.update');
Route::post('/admin/hang/controlDelete', [HangController::class, 'controlDelete'])->name('admin.hang.controlDelete');
Route::get('/admin/hang/edit/{id}', [HangController::class, 'edit'])->name('admin.hang.edit');



Route::post('/admin/khuyenmai/store', [KhuyenMaiController::class, 'store'])->name('admin.khuyenmai.store');
Route::post('/admin/khuyenmai/update', [KhuyenMaiController::class, 'update'])->name('admin.khuyenmai.update');
Route::post('/admin/khuyenmai/controlDelete', [KhuyenMaiController::class, 'controlDelete'])->name('admin.khuyenmai.controlDelete');


use App\Http\Controllers\HistoryController;

Route::get('/lich-su-don-hang', [HistoryController::class, 'showOrderHistory'])->name('order.history');
Route::get('/lich-su-don-hang/dadat', [HistoryController::class, 'showOrderStatusDADAT'])->name('order.history.dadat');
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaoHanhController;
use App\Http\Controllers\CTPNController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\HoaDonController;

use function Laravel\Prompts\alert;
Route::get('/yourInfo', function() {
    $email = app(Auth_BUS::class)->getEmailFromToken();
    $user = app(TaiKhoan_BUS::class)->getModelById($email);
    return view('client.AcctInfoOH', [
        'user'=>$user
    ]);
});

Route::get('/pay', function () {
    $email = app(Auth_BUS::class)->getEmailFromToken();
    // dd($email);
    $taikhoan = app(TaiKhoan_BUS::class)->getModelById($email);

    $user = $taikhoan->getIdNguoiDung();

    $listTinh = app(Tinh_BUS::class)->getAllModels();

    // dd($user);
    
    return view('client/pay', [
        'taikhoan' => $taikhoan,
        'user' => $user,
        'listTinh' => $listTinh,
    ]);
})->name('pay');
Route::get('/process', function() {
    return view('client.redirect');
});
// Route::view('/createdPayment','client.CreatePayment')->name('payment.create');
Route::post('/hoadon', [HoaDonController::class, 'store'])->name('hoadon.store');
Route::post('/admin/hoadon/update-status', [HoaDonController::class, 'updateStatus'])->name('admin.hoadon.update');
Route::get('client/paymentsuccess', [HoaDonController::class, 'paymentSuccess'])->name('payment.success');
Route::post('client/paid',[HoaDonController::class, 'paid'])->name('payment.paid');
Route::get('/createdPayment/search', [HoaDonController::class, 'search'])->name('payment.search');
Route::post('/createdPayment/changeStatus', [HoaDonController::class, 'changeStatusHD'])->name('payment.changestatus');
Route::get('/success', function() {
    $idhd = $_GET['idhd'];
    $hoaDon = app(HoaDon_BUS::class)->getModelById($idhd);
    return view('client.SuccessPayment', [
        'hoaDon' => $hoaDon
    ]);
});
Route::view('/createdPayment', 'client.MuaNgay');
Route::get('/getCTHD', [HoaDonController::class, 'getCTHDByIDSPAndIDHD'])->name('payment.getCTHDByIDSPAndIDHD');
Route::get('/muangay', [HoaDonController::class, 'muangay'])->name('payment.muangay');
Route::get('/createdPayMent', [HoaDonController::class, 'createdPayment'])->name('payment.create');
Route::view('/createPayment', 'client.CreatePayment');
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email-login');
    $password = $request->input('password-login');
    
    $auth = app()->make(AuthController::class);
    
    
    if ($auth->login($email, $password)) {
        $account = app(TaiKhoan_BUS::class)->getModelById($email);
        if (!$account) {
            return redirect()->back()->with('error', 'Tài khoản không tồn tại!');
        }
        if($account->getIdQuyen()->getId() == 1 || $account->getIdQuyen()->getId() == 2) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập qua trang quản trị!');
        } else {
            return redirect('/'); 
        }
    } else {
        return redirect()->back()->with('error','Tài khoản đã bị khóa!');
    }
})->name('login');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email-login');
    $password = $request->input('password-login');
    
    $auth = app()->make(AuthController::class);
    
    if ($auth->login($email, $password)) {
        $account = app(TaiKhoan_BUS::class)->getModelById($email);
        if($account->getIdQuyen()->getId() == 1 || $account->getIdQuyen()->getId() == 2) {
            return redirect('/admin'); 
        } else {
            return redirect('/admin/login')->with('error', 'Bạn không có quyền truy cập trang quản trị!');
        }
    } else {
        return redirect()->back()->with('error','Tài khoản đã bị khóa!');
    }
})->name('admin.login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register/register', [AuthController::class, 'register'])->name('register.register');
Route::post('/yourcart/update', [GioHangController::class, 'updateQuantity'])->name('cart.update');
Route::post('/yourcart/delete', [GioHangController::class, 'deleteCTGH'])->name('cart.delete');
Route::post('/index/addctgh', [GioHangController::class, 'add'])->name('index.addctgh');

Route::get('/getByPhieuNhapId/{id}', [CTPNController::class, 'getByPhieuNhapId']);
Route::post('/createPhieuNhap', [PhieuNhapController::class, 'store'])->name('phieunhap.store');

Route::post('/admin/quyen/store', [QuyenController::class, 'store'])->name('admin.quyen.store');
Route::post('/admin/quyen/update', [QuyenController::class, 'update'])->name('admin.quyen.update');
Route::post('/admin/quyen/destroy', [QuyenController::class, 'destroy'])->name('admin.quyen.destroy');

Route::get('/admin/thanhpho', [TinhController::class, 'index'])->name('admin.thanhpho');
Route::post('/admin/thanhpho', [TinhController::class, 'store'])->name('admin.thanhpho.store');
Route::delete('/admin/thanhpho/{id}', [TinhController::class, 'destroy'])->name('admin.thanhpho.destroy');

Route::post('/user/update-info', [NguoiDungController::class, 'updateInfo'])->name('user.updateInfo');

Route::get('/admin/thongke', [ThongKeController::class, 'index'])->name('admin.thongke');
Route::post('/admin/thongke/top', [ThongKeController::class, 'getTopCustomers'])->name('admin.thongke.top');
Route::post('/admin/thongke/orders', [ThongKeController::class, 'getCustomerOrders'])->name('admin.thongke.orders');
Route::get('/admin/thongke/details/{orderId}', [ThongKeController::class, 'getOrderDetails'])->name('admin.thongke.details');

Route::post('admin.baohanh.store', [BaoHanhController::class, 'store'])->name('admin.baohanh.store');

?>