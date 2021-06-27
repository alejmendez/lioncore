<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Person;
use App\Repositories\PersonRepository;
use App\Repositories\Eloquent\EloquentPersonRepository;
use App\Repositories\Cache\CachePersonDecorator;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Cache\CacheUserDecorator;

// add class

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function () {
            $repository = new EloquentUserRepository(new User());

            if (!config('app.cache')) {
                return $repository;
            }

            return new CacheUserDecorator($repository);
        });

        $this->app->bind(PersonRepository::class, function () {
            $repository = new EloquentPersonRepository(new Person());

            if (!config('app.cache')) {
                return $repository;
            }

            return new CachePersonDecorator($repository);
        });

        // add bind
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
