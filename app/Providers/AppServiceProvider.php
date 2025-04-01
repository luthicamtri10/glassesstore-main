<?php

namespace App\Providers;

use App\Bus\ChucNang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Dao\ChucNang_DAO;
use App\Dao\LoaiSanPham_DAO;
use App\Models\HoaDon;
use App\Models\SanPham;
use CTHD_BUS;
use CTHD_DAO;
use Illuminate\Support\ServiceProvider;
use App\Bus\SanPham_BUS;
use App\Dao\SanPham_DAO;
use CTSP_DAO;
use CTSP_BUS;
use HoaDon_BUS;
Use HoaDon_DAO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SanPham_DAO::class, function ($app) {
            return new SanPham_DAO();
        });

        $this->app->singleton(SanPham_BUS::class, function ($app) {
            return new SanPham_BUS($app->make(SanPham_DAO::class));
        });

        $this->app->bind(CTSP_DAO::class, function ($app) {
            return new CTSP_DAO();
        });

        $this->app->singleton(CTSP_BUS::class, function ($app) {
            return new CTSP_BUS($app->make(CTSP_DAO::class));
        });

        $this->app->bind(HoaDon_DAO::class, function ($app) {
            return new HoaDon_DAO();
        });

        $this->app->singleton(HoaDon_BUS::class, function ($app) {
            return new HoaDon_BUS($app->make(HoaDon_DAO::class));
        });

        $this->app->bind(CTHD_DAO::class, function ($app) {
            return new CTHD_DAO();
        });

        $this->app->singleton(CTHD_BUS::class, function ($app) {
            return new CTHD_BUS($app->make(CTHD_DAO::class));
        });

        $this->app->bind(LoaiSanPham_DAO::class, function ($app) {
            return new LoaiSanPham_DAO();
        });

        $this->app->singleton(LoaiSanPham_BUS::class, function ($app) {
            return new LoaiSanPham_BUS($app->make(CTHD_DAO::class));
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
