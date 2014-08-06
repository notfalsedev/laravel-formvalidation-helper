<?php

namespace Artisaninweb\FormValidationHelper;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('html', function ($app)
        {
            return new \Illuminate\Html\HtmlBuilder($app['url']);
        });

        $this->app->bindShared('form', function ($app)
        {
            $form = new \Artisaninweb\FormValidationHelper\FormBuilder($app['html'],$app['url'],$app['session.store']);

            return $form->setSessionStore($app['session.store']);
        });
    }

}