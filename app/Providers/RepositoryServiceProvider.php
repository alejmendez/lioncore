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

use App\Models\Property;
use App\Repositories\PropertyRepository;
use App\Repositories\Eloquent\EloquentPropertyRepository;
use App\Repositories\Cache\CachePropertyDecorator;

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

        $this->app->bind(PropertyRepository::class, function () {
            $repository = new EloquentPropertyRepository(new Property());

            if (!config('app.cache')) {
                return $repository;
            }

            return new CachePropertyDecorator($repository);
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
