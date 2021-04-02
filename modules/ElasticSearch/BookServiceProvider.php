<?php

namespace Modules\ElasticSearch;

use Illuminate\Support\ServiceProvider;
use Modules\ElasticSearch\Repositories\BookRepository;
use Modules\ElasticSearch\Repositories\Interfaces\BookRepositoryInterface;

/**
 * UserServiceProvider class
 */
class BookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BookRepositoryInterface::class,
            BookRepository::class
        );
    }
}
