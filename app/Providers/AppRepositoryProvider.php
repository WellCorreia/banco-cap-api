<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contract\ContaRepositoryInterface;
use App\Repositories\ContaRepository;

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
