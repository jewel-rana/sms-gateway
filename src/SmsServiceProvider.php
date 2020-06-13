<?php
namespace Rajtika\Sms;

use Illuminate\Support\ServiceProvider;
use Rajtika\Sms\Services\Sms;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sms', function () {
            return new Sms();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/sms.php' =>  config_path('sms.php'),
        ], 'config');
    }
}