<?php

namespace Witty\LaravelDbBackup;

use Witty\LaravelDbBackup\DatabaseBuilder;
use Illuminate\Support\ServiceProvider;

/**
 * Class DBBackupServiceProvider
 * @package Witty\LaravelDbBackup
 */
class DBBackupServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('db-backup.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $databaseBuilder = new DatabaseBuilder();

        $this->app->singleton('db.backup', function () use ($databaseBuilder) {
            return new Commands\BackupCommand($databaseBuilder);
        });

        $this->app->singleton('db.restore', function () use ($databaseBuilder) {
            return new Commands\RestoreCommand($databaseBuilder);
        });

        $this->commands(
            'db.backup',
            'db.restore'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}
