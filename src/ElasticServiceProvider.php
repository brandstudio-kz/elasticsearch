<?php

namespace BrandStudio\Elasticsearch;

use Illuminate\Support\ServiceProvider;
use BrandStudio\Elasticsearch\ElasticClient;
use BrandStudio\Elasticsearch\Console\Commands\ElasticConfiguratorCommand;

class ElasticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerCommands();
        $this->app->singleton(ElasticClient::class, function($app) {
            return new ElasticClient($app->config['brandstudio']['elasticsearch']);
        });
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/elasticsearch.php', 'brandstudio.elasticsearch'
        );
    }

    private function registerCommands()
    {
        $this->commands([
            ElasticConfiguratorCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishFiles();
    }

    private function publishFiles()
    {
        $this->publishes([
            __DIR__.'/config/elasticsearch.php' => config_path('brandstudio/elasticsearch.php')
        ], 'config');
    }
}
