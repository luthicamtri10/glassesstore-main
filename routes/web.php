<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('admin.index');
});

Route::get('/admin', function () {
    return view('admin.index'); // Đây sẽ tìm file ở resources/views/admin/index.blade.php
});

Route::get('/admin/quyen', function () {
    return view('admin.quyen'); // Đây sẽ tìm file ở resources/views/admin/quyen.blade.php
});

Route::get('/admin/baohanh', function () {
    return view('admin.baohanh'); 
});

Route::get('/admin/donvivanchuyen', function () {
    return view('admin.donvivanchuyen'); 
});

Route::get('/admin/hang', function () {
    return view('admin.hang'); 
});

Route::get('/admin/hoadon', function () {
    return view('admin.hoadon'); 
});

Route::get('/admin/kho', function () {
    return view('admin.kho'); 
});

Route::get('/admin/khuyenmai', function () {
    return view('admin.khuyenmai'); 
});

Route::get('/admin/loaisanpham', function () {
    return view('admin.loaisanpham'); 
});

Route::get('/admin/nguoidung', function () {
    return view('admin.nguoidung'); 
});

Route::get('/admin/nhacungcap', function () {
    return view('admin.nhacungcap'); 
});

Route::get('/admin/sanpham', function () {
    return view('admin.sanpham'); 
});

Route::get('/admin/taikhoan', function () {
    return view('admin.taikhoan'); 
});

Route::get('/admin/thanhpho', function () {
    return view('admin.thanhpho'); 
});

Route::get('/admin/thongke', function () {
    return view('admin.thongke'); 
});

