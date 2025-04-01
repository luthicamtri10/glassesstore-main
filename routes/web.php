<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SanPhamController;

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
Route::view('/', 'admin.includes.sidebar'); 
Route::view('/admin', 'admin.includes.sidebar');

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
        'nhacungcap', 'sanpham', 'taikhoan', 'thanhpho', 'thongke'
    ];

    if (!in_array($page, $validPages)) {
        abort(404);
    }

    // Nếu là AJAX request, trả về view nhỏ gọn
    if (request()->ajax()) {
        return view("admin.{$page}");
    }

    // Nếu load trực tiếp (nhập URL), trả về layout đầy đủ
    return view('admin.includes.sidebar');
})->where('page', '[a-z]+');



Route::get('/sanpham', [SanPhamController::class, 'index'])->name('sanpham.index');
Route::post('/sanpham', [SanPhamController::class, 'store'])->name('sanpham.store');
Route::delete('/sanpham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');

