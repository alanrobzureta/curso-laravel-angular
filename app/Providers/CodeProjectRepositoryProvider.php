<?php

namespace CodeProject\Providers;

use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
                \CodeProject\Repositories\ClientRepository::class, //abstract
                \CodeProject\Repositories\ClientRepositoryEloquent::class //concrete                
        );
        $this->app->bind(
                \CodeProject\Repositories\ProjectRepository::class, //abstract
                \CodeProject\Repositories\ProjectRepositoryEloquent::class //concrete
        );
    }
}
