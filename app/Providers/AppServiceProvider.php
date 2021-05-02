<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use App\View\Components\InputComponent;
use App\View\Components\SelectComponent;

use App\Models\Person;
use App\Repositories\PersonRepository;
use App\Repositories\Eloquent\EloquentPersonRepository;
use App\Repositories\Cache\CachePersonDecorator;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Cache\CacheUserDecorator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    private function registerBindings()
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('select', SelectComponent::class);
        Blade::component('input', InputComponent::class);
    }
}
