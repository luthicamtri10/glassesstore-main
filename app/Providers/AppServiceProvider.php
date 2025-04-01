<?php

namespace App\Providers;

use App\Bus\ChucNang_BUS;
use App\Bus\CTQ_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Dao\ChucNang_DAO;
use App\Dao\CTQ_DAO;
use App\Dao\NguoiDung_DAO;
use App\Dao\Quyen_DAO;
use App\Dao\TaiKhoan_DAO;
use App\Dao\Tinh_DAO;
use CTHD_BUS;
use CTHD_DAO;
use CTSP_BUS;
use CTSP_DAO;
use HoaDon_BUS;
use HoaDon_DAO;
use Illuminate\Support\ServiceProvider;
use SanPham_BUS;
use SanPham_DAO;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 
    }
}