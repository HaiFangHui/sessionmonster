<?php namespace HaiFangHui\SessionMonster;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SessionMonsterServiceProvider extends ServiceProvider {

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
		$this->package('haifanghui/session-monster');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->after(function ($request, $response) {
                $session = Session::all();

                unset($session['_token']);

                $empty_flash = true;
                if (isset($session['flash'])) {
                    if (is_array($session['flash']['old']) && (count($session['flash']['old']) > 0)) {
                        $empty_flash = false;
                    }
                    
                    if (is_array($session['flash']['new']) && (count($session['flash']['new']) > 0)) {
                        $empty_flash = false;
                    }
                }
                
                if ($empty_flash) {
                    unset($session['flash']);
                }

                if (count($session) >= 1) {
                    return;
                }
                
                $response->headers->set('X-No-Session', 'yeah');
            });
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
