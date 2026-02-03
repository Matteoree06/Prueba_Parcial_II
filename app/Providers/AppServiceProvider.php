<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UsuarioRepository;
use App\Repositories\Interfaces\ProductoRepository;
use App\Repositories\Interfaces\ProductoRepositoryImpl;
use App\Repositories\Interfaces\UsuarioRepositoryImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UsuarioRepository::class,
            UsuarioRepositoryImpl::class
        );
        $this->app->bind(
            ProductoRepository::class,
            ProductoRepositoryImpl::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
