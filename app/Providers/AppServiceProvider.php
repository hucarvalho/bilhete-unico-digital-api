<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
            'App\Repositories\Contracts\PassagemRepositoryInterface',
            'App\Repositories\Eloquent\PassagemRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\AjudaRepositoryInterface',
            'App\Repositories\Eloquent\AjudaRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\PassageiroRepositoryInterface',
            'App\Repositories\Eloquent\PassageiroRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\CartaoRepositoryInterface',
            'App\Repositories\Eloquent\CartaoRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\BilheteRepositoryInterface',
            'App\Repositories\Eloquent\BilheteRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\PedidoBilheteRespositoryInterface',
            'App\Repositories\Eloquent\PedidoBilheteRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
