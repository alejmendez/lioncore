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

use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Cache\CacheRoleDecorator;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use App\Repositories\Eloquent\EloquentEmployeeRepository;
use App\Repositories\Cache\CacheEmployeeDecorator;

use App\Models\Navigation;
use App\Repositories\NavigationRepository;
use App\Repositories\Eloquent\EloquentNavigationRepository;
use App\Repositories\Cache\CacheNavigationDecorator;

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

        $this->app->bind(RoleRepository::class, function () {
            $repository = new EloquentRoleRepository(new Role());

            if (!config('app.cache')) {
                return $repository;
            }

            return new CacheRoleDecorator($repository);
        });

        $this->app->bind(EmployeeRepository::class, function () {
            $repository = new EloquentEmployeeRepository(new Employee());

            if (!config('app.cache')) {
                return $repository;
            }

            return new CacheEmployeeDecorator($repository);
        });

        $this->app->bind(NavigationRepository::class, function () {
            $repository = new EloquentNavigationRepository(new Navigation());
        
            if (!config('app.cache')) {
                return $repository;
            }
        
            return new CacheNavigationDecorator($repository);
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
