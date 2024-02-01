<?php

namespace KMsalehi\LaravelEzCrud;

use Illuminate\Support\ServiceProvider;

class EzCrudServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'ez-crud');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/ez-crud'),
        ]);

        if($this->app->runningInConsole()) {
            $this->commands([
                CrudGeneratorMakeCommand::class,
                PublishCrudStubCommand::class
            ]);
        }
    }
}
