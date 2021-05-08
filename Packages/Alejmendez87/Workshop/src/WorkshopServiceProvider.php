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
                __DIR__.'/../database/migrations/audits.stub' => database_path(
                    sprintf('migrations/%s_create_audits_table.php', date('Y_m_d_His'))
                ),
            ], 'migrations');
        }
    }
}
