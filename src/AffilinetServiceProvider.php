<?php

/*
 * This file is part of Laravel Affilinet.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Affilinet;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class AffilinetServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-affilinet.php' => config_path('laravel-affilinet.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-affilinet.php', 'laravel-affilinet');

        $this->registerFactory();

        $this->registerManager();

        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'affilinet',
            'affilinet.factory',
            'affilinet.connection',
        ];
    }

    /**
     * Register the factory class.
     */
    protected function registerFactory()
    {
        $this->app->singleton('affilinet.factory', function () {
            return new AffilinetFactory();
        });

        $this->app->alias('affilinet.factory', AffilinetFactory::class);
    }

    /**
     * Register the manager class.
     */
    protected function registerManager()
    {
        $this->app->singleton('affilinet', function (Container $app) {
            $config = $app['config'];
            $factory = $app['affilinet.factory'];

            return new AffilinetManager($config, $factory);
        });

        $this->app->alias('affilinet', AffilinetManager::class);
    }

    /**
     * Register the bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind('affilinet.connection', function (Container $app) {
            $manager = $app['affilinet'];

            return $manager->connection();
        });

        $this->app->alias('affilinet.connection', Affilinet::class);
    }
}
