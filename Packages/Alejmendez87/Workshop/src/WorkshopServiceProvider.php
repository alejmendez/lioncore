<?php

namespace Alejmendez87\Workshop;

use Illuminate\Support\ServiceProvider;
use Alejmendez87\Workshop\Console\GenerateGrud;

class WorkshopServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateGrud::class,
            ]);
        }
        $this->mergeConfigFrom(__DIR__.'/../config/workshop.php', 'workshop');
        $this->loadViewsFrom(__DIR__.'/resources/views/scaffolding', 'workshop');
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            // Lumen lacks a config_path() helper, so we use base_path()
            $this->publishes([
                __DIR__.'/../config/workshop.php' => base_path('config/workshop.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/resources/controller.blade.php' => resource_path('views/workshop/controller.blade.php'),
                __DIR__ . '/resources/factory.blade.php' => resource_path('views/workshop/factory.blade.php'),
                __DIR__ . '/resources/formRequest.blade.php' => resource_path('views/workshop/formRequest.blade.php'),
                __DIR__ . '/resources/migration.blade.php' => resource_path('views/workshop/migration.blade.php'),
                __DIR__ . '/resources/model.blade.php' => resource_path('views/workshop/model.blade.php'),
                __DIR__ . '/resources/repository.blade.php' => resource_path('views/workshop/repository.blade.php'),
                __DIR__ . '/resources/routeVue.blade.php' => resource_path('views/workshop/routeVue.blade.php'),
                __DIR__ . '/resources/test.blade.php' => resource_path('views/workshop/test.blade.php'),
                __DIR__ . '/resources/views/form.blade.php' => resource_path('views/workshop/views/form.blade.php'),
                __DIR__ . '/resources/views/trans.blade.php' => resource_path('views/workshop/views/trans.blade.php'),
                __DIR__ . '/resources/views/list/datatable.blade.php' => resource_path('views/workshop/views/list/datatable.blade.php'),
                __DIR__ . '/resources/views/list/filters.blade.php' => resource_path('views/workshop/views/list/filters.blade.php'),
                __DIR__ . '/resources/views/list/list.blade.php' => resource_path('views/workshop/views/list/list.blade.php'),
                __DIR__ . '/resources/views/store/actions.blade.php' => resource_path('views/workshop/views/store/actions.blade.php'),
                __DIR__ . '/resources/views/store/getters.blade.php' => resource_path('views/workshop/views/store/getters.blade.php'),
                __DIR__ . '/resources/views/store/module.blade.php' => resource_path('views/workshop/views/store/module.blade.php'),
                __DIR__ . '/resources/views/store/mutations.blade.php' => resource_path('views/workshop/views/store/mutations.blade.php'),
                __DIR__ . '/resources/views/store/state.blade.php' => resource_path('views/workshop/views/store/state.blade.php'),
            ], 'views');
        }
    }
}
