<?php

use App\Bus\TaiKhoan_BUS;
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
Route::view('/', 'layout.admin'); 
Route::view('/admin', 'layout.admin');
Route::get('/sanpham', [SanPhamController::class, 'index'])->name('sanpham.index');
Route::post('/sanpham', [SanPhamController::class, 'store'])->name('sanpham.store');
Route::delete('/sanpham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');

Route::post('/admin/taikhoan/store', [TaiKhoanController::class, 'store'])->name('admin.taikhoan.store');
Route::post('/admin/taikhoan/update', [TaiKhoanController::class, 'update'])->name('admin.taikhoan.update');
Route::post('/admin/taikhoan/controldelete', [TaiKhoanController::class, 'controlDelete'])->name('admin.taikhoan.controlDelete');
?>
