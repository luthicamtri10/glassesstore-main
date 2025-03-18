<?php

namespace App\Providers;

use App\Bus\ChucNang_BUS;
use App\Dao\ChucNang_DAO;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Đăng ký DAO và BUS làm singleton để Laravel quản lý
        $this->app->singleton(ChucNang_DAO::class, function ($app) {
            return new ChucNang_DAO();
        });

        $this->app->singleton(ChucNang_BUS::class, function ($app) {
            return new ChucNang_BUS();
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
