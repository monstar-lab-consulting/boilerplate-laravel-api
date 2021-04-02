<?php

namespace Modules;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

/**
 * ModulesServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 */
class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     *
     * @return void
     */
    public function boot()
    {
        $directories = array_map('basename', File::directories(__DIR__));
        foreach ($directories as $moduleName) {
            if ($moduleName === 'Boilerplates') {
                continue;
            }
            $this->registerModule($moduleName);
        }
    }

    /**
     * Register module
     *
     * @param $moduleName moduleName
     *
     * @return void
     */
    private function registerModule($moduleName)
    {
        $modulePath = __DIR__ . "/$moduleName/";
        // boot route
        if (File::exists($modulePath . "routes.php")) {
            $this->loadRoutesFrom($modulePath . "routes.php");
        }
        // boot views
        if (File::exists($modulePath . "Views")) {
            $this->loadViewsFrom($modulePath . "Views", $moduleName);
        }
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Modules\Users\UserServiceProvider');
        $this->app->register('Modules\ElasticSearch\BookServiceProvider');
    }
}
