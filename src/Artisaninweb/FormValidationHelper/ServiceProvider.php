<?php

namespace Artisaninweb\FormValidationHelper;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Artisaninweb\FormValidationHelper\FormBuilder;
use Illuminate\Html\HtmlBuilder;

class ServiceProvider extends LaravelServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('html', function ($app)
        {
            return new HtmlBuilder($app['url']);
        });

        $this->app->bindShared('form', function ($app)
        {
            return (new FormBuilder($app['html'],$app['url'],$app['session.store']))
                    ->setSessionStore($app['session.store']);
        });
    }

}