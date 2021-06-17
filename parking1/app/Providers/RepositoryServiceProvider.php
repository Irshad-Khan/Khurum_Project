<?php

namespace App\Providers;

use App\Contracts\AuthInterface;
use App\Contracts\ProfileInterface;
use App\Repositories\AuthRepository;
use App\Repositories\ProfileRepositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(ProfileInterface::class, ProfileRepositories::class);
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
