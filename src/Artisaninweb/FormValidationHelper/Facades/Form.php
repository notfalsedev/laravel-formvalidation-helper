<?php

namespace Artisaninweb\FormValidationHelper\Facades;

use Illuminate\Support\Facades\Facade as Facade;

class Form extends Facade {

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'form';
    }

}