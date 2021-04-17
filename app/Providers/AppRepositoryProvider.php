<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contract\ContaRepositoryInterface;
use App\Repositories\ContaRepository;
use App\Repositories\Contract\TransacaoRepositoryInterface;
use App\Repositories\TransacaoRepository;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ContaRepositoryInterface::class,
            ContaRepository::class,
        );
        $this->app->bind(
            TransacaoRepositoryInterface::class,
            TransacaoRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
