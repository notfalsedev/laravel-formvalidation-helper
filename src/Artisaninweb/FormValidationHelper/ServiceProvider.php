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
            $form = new FormBuilder($app['html'],$app['url'],$app['session.store']);

            return $form->setSessionStore($app['session.store']);
        });
    }

}