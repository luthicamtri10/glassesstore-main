<?php

namespace App\Providers;

use App\Bus\ChucNang_BUS;
use App\Bus\CPVC_BUS;
use App\Dao\ChucNang_DAO;
use App\Dao\CPVC_DAO;
use App\Models\ChucNang;
use App\Models\CPVC;
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
       
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
