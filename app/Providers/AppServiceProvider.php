<?php

namespace App\Providers;

use App\Bus\ChucNang_BUS;

use App\Bus\CPVC_BUS;
use App\Dao\ChucNang_DAO;
use App\Dao\CPVC_DAO;
use App\Models\ChucNang;
use App\Models\CPVC;

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
use App\Models\TaiKhoan;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(ChucNang_DAO::class, function ($app) {
            return new ChucNang_DAO();
        });
        $this->app->singleton(ChucNang_BUS::class, function ($app) {
            return new ChucNang_BUS($app->make(ChucNang_DAO::class));
        });
        $this->app->bind(CPVC_DAO::class, function ($app) {
            return new CPVC_DAO();
        });
        $this->app->singleton(CPVC_BUS::class, function ($app) {
            return new CPVC_BUS($app->make(CPVC_DAO::class));
        });
       
        

        $this->app->singleton(ChucNang_DAO::class, function ($app) {
            return new ChucNang_DAO();
        });
        $this->app->singleton(ChucNang_BUS::class, function ($app) {
            return new ChucNang_BUS();
        });
        $this->app->singleton(CTQ_DAO::class, function ($app) {
            return new CTQ_DAO();
        });
        $this->app->singleton(CTQ_BUS::class, function ($app) {
            return new CTQ_BUS();
        });
        $this->app->singleton(NguoiDung_DAO::class, function ($app) {
            return new NguoiDung_DAO();
        });
        $this->app->singleton(NguoiDung_BUS::class, function ($app) {
            return new NguoiDung_BUS();
        });
        $this->app->singleton(Quyen_DAO::class, function ($app) {
            return new Quyen_DAO();
        });
        $this->app->singleton(Quyen_BUS::class, function ($app) {
            return new Quyen_BUS();
        });
        $this->app->singleton(TaiKhoan_DAO::class, function ($app) {
            return new TaiKhoan_DAO();
        });
        $this->app->singleton(TaiKhoan_BUS::class, function ($app) {
            return new TaiKhoan_BUS();
        });
        $this->app->singleton(Tinh_DAO::class, function ($app) {
            return new Tinh_DAO();
        });
        $this->app->singleton(Tinh_BUS::class, function ($app) {
            return new Tinh_BUS();
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
