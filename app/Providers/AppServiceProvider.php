<?php

namespace App\Providers;

use App\Bus\Auth_BUS;
use App\Bus\ChiTietBaoHanh_BUS;
use App\Bus\ChucNang_BUS;
use App\Bus\CPVC_BUS;
use App\Bus\CTQ_BUS;
use App\Bus\DVVC_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\KhuyenMai_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NCC_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PhieuNhap_BUS;
use App\Bus\PTTT_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Dao\ChiTietBaoHanh_DAO;
use App\Dao\ChucNang_DAO;
use App\Dao\CPVC_DAO;
use App\Dao\CTQ_DAO;
use App\Dao\DVVC_DAO;
use App\Dao\GioHang_DAO;
use App\Dao\Hang_DAO;
use App\Dao\KhuyenMai_DAO;
use App\Dao\LoaiSanPham_DAO;
use App\Dao\NCC_DAO;
use App\Dao\NguoiDung_DAO;
use App\Dao\PhieuNhap_DAO;
use App\Dao\PTTT_DAO;
use App\Dao\Quyen_DAO;
use App\Dao\TaiKhoan_DAO;
use App\Dao\Tinh_DAO;
use App\Dao\SanPham_DAO;
use App\Utils\JWTUtils;
use App\Validates\validation;
use App\Bus\CTHD_BUS;
use App\Dao\CTHD_DAO;
use App\Bus\CTSP_BUS;
use App\Dao\CTSP_DAO;
use App\Bus\HoaDon_BUS;
use App\Dao\HoaDon_DAO;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Định nghĩa các lớp DAO và BUS.
     *
     * @var array
     */
    protected $services = [
        'ChucNang' => [ChucNang_DAO::class, ChucNang_BUS::class],
        'CTQ' => [CTQ_DAO::class, CTQ_BUS::class],
        'NguoiDung' => [NguoiDung_DAO::class, NguoiDung_BUS::class],
        'Quyen' => [Quyen_DAO::class, Quyen_BUS::class],
        'TaiKhoan' => [TaiKhoan_DAO::class, TaiKhoan_BUS::class],
        'Tinh' => [Tinh_DAO::class, Tinh_BUS::class],
        'SanPham' => [SanPham_DAO::class, SanPham_BUS::class],
        'CTSP' => [CTSP_DAO::class, CTSP_BUS::class],
        'HoaDon' => [HoaDon_DAO::class, HoaDon_BUS::class],
        'CTHD' => [CTHD_DAO::class, CTHD_BUS::class],
        'ChiTietBaoHanh' => [ChiTietBaoHanh_DAO::class, ChiTietBaoHanh_BUS::class],
        'CPVC' => [CPVC_DAO::class, CPVC_BUS::class],
        'CTPN' => [CTSP_DAO::class, CTSP_BUS::class],
        'PhieuNhap' => [PhieuNhap_DAO::class, PhieuNhap_BUS::class],
        'DVVC' => [DVVC_DAO::class, DVVC_BUS::class],
        'GioHang' => [GioHang_DAO::class, GioHang_BUS::class],
        'Hang' => [Hang_DAO::class, Hang_BUS::class],
        'KhuyenMai' => [KhuyenMai_DAO::class, KhuyenMai_BUS::class],
        'LoaiSanPham' => [LoaiSanPham_DAO::class, LoaiSanPham_BUS::class],
        'NCC' => [NCC_DAO::class, NCC_BUS::class],
        'PTTT' => [PTTT_DAO::class, PTTT_BUS::class],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->services as $classes) {
            $this->app->bind($classes[0], function ($app) use ($classes) {
                return new $classes[0](); // Sử dụng classes[0] đã được truyền vào
            });

            $this->app->singleton($classes[1], function ($app) use ($classes) {
                return new $classes[1]($app->make($classes[0])); // Sử dụng classes[1] đã được truyền vào
            });
        }
        $this->app->singleton(validation::class, function($app) {
            return new validation();
        });
        $this->app->singleton(Auth_BUS::class, function ($app) {
            return new Auth_BUS($app->make(TaiKhoan_BUS::class), $app->make(JWTUtils::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 
    }
}