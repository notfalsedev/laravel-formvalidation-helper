<?php

namespace Artisaninweb\FormValidationHelper\Extension;

use Artisaninweb\FormValidationHelper\FormBuilder;
use TwigBridge\Extension\Laravel\Form;

/**
 * Access Laravels form builder in your Twig templates.
 */
class TwigBridgeForm extends Form {

    /**
     * The constructor
     *
     * @param FormBuilder $form
     */
    public function __construct(FormBuilder $form)
    {
        $this->form = $form;
    }

}