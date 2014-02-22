<?php namespace Kareem3d\Freak;

use Illuminate\Support\ClassLoader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Kareem3d\Freak\Freak;
use Kareem3d\Membership\Account;

class FreakServiceProvider extends ServiceProvider {

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
        $this->app->singleton('Kareem3d\Freak\Freak', function ()
        {
            $name     = Config::get('freak::general.name');
            $password = Config::get('freak::general.password');

            return new Freak($name, $password, array(), array());
        });
    }

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->package('kareem3d/freak');

        // Require routes and helpers files
        require __DIR__ . '/../../helpers.php';
        require __DIR__ . '/../../routes.php';

        if($this->freakRequest())
        {
            $freak = $this->app->make('Kareem3d\Freak\Freak');

            // Load controllers
            ClassLoader::addDirectories(Config::get('freak::paths.directories.controllers'));

            // Load views
            View::addNamespace($freak->getName(), Config::get('freak::paths.directories.views'));

            // Set authentication model to freak user.
            Config::set('auth.model', Account::getClass());

            // Load elements and add them to the freak
            $elements = $this->app->make('Kareem3d\Freak\Factories\ElementFactory')

                ->fromArray(require Config::get('freak::paths.configurations.elements'));

            $freak->addElements($elements);
        }
	}

    /**
     * @return bool
     */
    public function freakRequest()
    {
        $domain = trim(Config::get('freak::routes.domain'), '/');
        $prefix = trim(Config::get('freak::routes.prefix'), '/');

        $path = trim(Request::path(), '/');

        if ($prefix)
        {
            if (strpos($path, $prefix) !== 0) return false;
        }

        if ($domain)
        {
            if (Request::getHttpHost() != $domain) return false;
        }

        return true;
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}