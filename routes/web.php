<?php

use App\Bus\TaiKhoan_BUS;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
Route::view('/', 'layout.admin'); 
Route::view('/admin', 'layout.admin');

Route::get('/', function () {
    return redirect('/admin/nguoidung');
});

Route::get('/admin', function () {
    return redirect('/admin/nguoidung');
});


Route::get('/admin/{page}', function ($page) {
    $validPages = [
        'quyen', 'baohanh', 'donvivanchuyen', 'hang', 'hoadon', 
        'kho', 'khuyenmai', 'loaisanpham', 'nguoidung', 
        'nhacungcap', 'sanpham', 'thanhpho', 'thongke', 'taikhoan'
    ];

    if (!in_array($page, $validPages)) {
        abort(404);
    }
    // if($page === 'taikhoan') {
    //     session_start();

    //     $taiKhoanBUS = app(TaiKhoan_BUS::class);
    //     $listTK = $taiKhoanBUS->getAllModels();

    //     $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    //     $limit = 8;
    //     $total_record = count($listTK);
    //     $total_page = ceil($total_record / $limit);
    //     $current_page = max(1, min($current_page, $total_page));
    //     $start = ($current_page - 1) * $limit;
    //     $tmp = array_slice($listTK, $start, $limit);

    //     return view('admin.taikhoan', compact('tmp', 'current_page', 'total_page'));
    // }
    // Nếu là AJAX request, trả về view nhỏ gọn
    if (request()->ajax()) {
        return view("admin.{$page}");
    }

    

    // Nếu load trực tiếp (nhập URL), trả về layout đầy đủ
    return view('layout.admin');
})->where('page', '[a-z]+');

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
Route::view('/', 'layout.admin'); 
Route::view('/admin', 'layout.admin');

Route::get('/', function () {
    return redirect('/admin/nguoidung');
});

Route::get('/admin', function () {
    return redirect('/admin/nguoidung');
});


Route::get('/admin/{page}', function ($page, Request $request) {
    $validPages = [
        'quyen', 'baohanh', 'donvivanchuyen', 'hang', 'hoadon', 
        'kho', 'khuyenmai', 'loaisanpham', 'nguoidung', 
        'nhacungcap', 'sanpham', 'thanhpho', 'thongke', 'taikhoan'
    ];

    if (!in_array($page, $validPages)) {
        abort(404);
    }
    // Nếu là AJAX request, trả về view nhỏ gọn
    if (request()->ajax()) {
        
        return view("admin.{$page}");
    }
    if($page === 'taikhoan') {
        session_start();

        $taiKhoanBUS = app(TaiKhoan_BUS::class);
        $listTK = $taiKhoanBUS->getAllModels();

        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 8;
        $total_record = count($listTK);
        $total_page = ceil($total_record / $limit);
        $current_page = max(1, min($current_page, $total_page));
        $start = ($current_page - 1) * $limit;
        $tmp = array_slice($listTK, $start, $limit);
        return view('admin.taikhoan', compact('tmp', 'current_page', 'total_page'));
    }
    // Nếu load trực tiếp (nhập URL), trả về layout đầy đủ
    return view('layout.admin');
})->where('page', '[a-z]+');

Route::get('/login', function() {
    if(request()->ajax()) {
        return view('client.Login-Register');
    }
    return view('layout.index');
});