<?php namespace Nathanmac\Utilities\Responder;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * ResponderServiceProvider, supporting Laravel implementations.
 *
 * @package    Nathanmac\Utilities\Responder
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class ResponderServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Responder', function($app) {
            return new Responder;
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('nathanmac/responder');

        AliasLoader::getInstance()->alias(
            'Responder',
            'Nathanmac\Utilities\Responder\Facades\Responder'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Responder');
    }

}
