<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contract\ContaServiceInterface;
use App\Services\ContaService;
use App\Http\Resources\ContaResource;
use App\Services\Contract\TransacaoServiceInterface;
use App\Services\TransacaoService;
use App\Http\Resources\TransacaoResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ContaServiceInterface::class,
            ContaService::class,
        );
        $this->app->bind(
            TransacaoServiceInterface::class,
            TransacaoService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ContaResource::withoutWrapping();
        TransacaoResource::withoutWrapping();
    }
}
