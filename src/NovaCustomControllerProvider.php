<?php

namespace PtDotPlayground\NovaCustomController;

use App\Nova\Resource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use PtDotPlayground\NovaCustomController\Traits\NovaCustomEvents;

class NovaCustomControllerProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'PtDotPlayground\NovaCustomController\Http\Controllers';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(__DIR__ . '/Helpers/*.php') as $file) {
            require_once $file;
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $usingTrait = in_array(
                NovaCustomEvents::class,
                array_keys((new \ReflectionClass(Resource::class))->getTraits())
            );

            if ($usingTrait) $this->routes();
        });
    }

    /**
     * Register the routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->namespace($this->namespace)
            ->name('nova.api.')
            ->where(['any' => 'nova-api'])
            ->group(__DIR__.'/../routes/api-nova.php');
    }
}
