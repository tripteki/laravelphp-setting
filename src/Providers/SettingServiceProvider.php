<?php

namespace Tripteki\Setting\Providers;

use Tripteki\Setting\Console\Commands\InstallCommand;
use Tripteki\Repository\Providers\RepositoryServiceProvider as ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $repositories =
    [
        \Tripteki\Setting\Contracts\Repository\ISettingRepository::class => \Tripteki\Setting\Repositories\Eloquent\SettingRepository::class,
        \Tripteki\Setting\Contracts\Repository\Admin\ISettingRepository::class => \Tripteki\Setting\Repositories\Eloquent\Admin\SettingRepository::class,
    ];

    /**
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * @return bool
     */
    public static function shouldRunMigrations()
    {
        return static::$runsMigrations;
    }

    /**
     * @return void
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
    }

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerPublishers();
        $this->registerCommands();
        $this->registerMigrations();
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        if (! $this->app->isProduction() && $this->app->runningInConsole()) {

            $this->commands(
            [
                InstallCommand::class,
            ]);
        }
    }

    /**
     * @return void
     */
    protected function registerMigrations()
    {
        if ($this->app->runningInConsole() && static::shouldRunMigrations()) {

            $this->loadMigrationsFrom(__DIR__."/../../database/migrations");
        }
    }

    /**
     * @return void
     */
    protected function registerPublishers()
    {
        if (! static::shouldRunMigrations()) {

            $this->publishes(
            [
                __DIR__."/../../database/migrations" => database_path("migrations"),
            ],

            "tripteki-laravelphp-setting-migrations");
        }

        $this->publishes(
        [
            __DIR__."/../../stubs/tests/Feature/Setting/SettingTest.stub" => base_path("tests/Feature/Setting/SettingTest.php"),
        ],

        "tripteki-laravelphp-setting-tests");
    }
};
