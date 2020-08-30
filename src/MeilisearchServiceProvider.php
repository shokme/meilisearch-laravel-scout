<?php

namespace Meilisearch\Scout;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use Meilisearch\Scout\Console\IndexMeilisearch;
use Meilisearch\Scout\Engines\MeilisearchEngine;

class MeilisearchServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'meilisearch');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('meilisearch.php'),
            ], 'config');

            $this->commands([IndexMeilisearch::class]);
        }

        resolve(EngineManager::class)->extend('meilisearch', function () {
            return new MeilisearchEngine(
                (new MeilisearchClient())->getClient(),
                config('scout.soft_delete', false)
            );
        });
    }
}
