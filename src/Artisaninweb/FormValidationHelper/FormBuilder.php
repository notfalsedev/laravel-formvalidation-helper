<?php

namespace Artisaninweb\FormValidationHelper;

use Illuminate\Html\FormBuilder as LaravelFormBuilder;
use Illuminate\Session\Store as Session;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class FormBuilder extends LaravelFormBuilder {

    /**
     * @var array
     */
    protected $requiredFields;

    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var array
     */
    protected $errorFields;

    /**
     * The constructor
     *
     * @param HtmlBuilder  $html
     * @param UrlGenerator $url
     * @param Session      $session
     */
    public function __construct(HtmlBuilder $html, UrlGenerator $url, Session $session)
    {
        parent::__construct($html,$url,$session->getToken());

        $this->session        = $session;
        $this->requiredFields = [];
        $this->errorFields    = [];

        if($this->session->has('formhelper-required-fields'))
        {
            $this->requiredFields = $this->session->get('formhelper-required-fields');

            $this->session->forget('formhelper-required-fields');
        }

        if($this->session->has('formhelper-error-fields'))
        {
            $this->errorFields = $this->session->get('formhelper-error-fields');

            $this->session->forget('formhelper-error-fields');
        }
    }

    /**
     * Validate the post data
     *
     * @param $callback
     * @return mixed
     */
    public function validate($callback)
    {
        $postData  = Input::get();
        $validator = Validator::make($postData,$this->getRequiredFields());
        $passes    = true;
        $messages  = [];

        if($validator->fails())
        {
            $messages = $validator->messages();
            $passes   = false;

            $this->session->put('formhelper-error-fields',$messages);
        }

        return $callback($postData,$passes,$messages);
    }

    /**
     * Create a form input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    public function input($type,$name,$value=null,$options=array())
    {
        $options = $this->addErrorClass($name,$options);
        $options = $this->checkRequired($name,$options);

        return parent::input($type,$name,$value,$options);
    }

    /**
     * Create a textarea input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    public function textarea($name,$value=null,$options=array())
    {
        $options = $this->addErrorClass($name,$options);
        $options = $this->checkRequired($name,$options);

        return parent::textarea($name,$value,$options);
    }

    /**
     * Create a select box field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string $selected
     * @param  array  $options
     * @return string
     */
    public function select($name,$list=array(),$selected=null,$options=array())
    {
        $options = $this->addErrorClass($name,$options);
        $options = $this->checkRequired($name,$options);

        return parent::select($name,$list,$selected,$options);
    }

    /**
     * Close the current form.
     *
     * @return string
     */
    public function close()
    {
        $this->session->put('formhelper-required-fields',$this->requiredFields);

        return parent::close();
    }

    /**
     * Get a error message
     *
     * @param        $name
     * @param null   $customError
     * @return null
     */
    public function error($name,$customError=null)
    {
        if($this->hasError($name))
        {
            if(null != $customError)
            {
                return $this->errorFields->first($name,$customError);
            }
            return '<span class="error-msg">'.$this->errorFields->first($name).'</span>';
        }
        return null;
    }

    /**
     * Check if field has a error
     *
     * @param $name
     * @return bool
     */
    protected function hasError($name)
    {
        if(!empty($this->errorFields))
        {
            $error = $this->errorFields->first($name);

            if(!empty($error))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Add error class to the input/select/textarea/ect
     *
     * @param $name
     * @param $options
     * @return mixed
     */
    protected function addErrorClass($name,$options)
    {
        $errorClass = (!empty($options['error-class'])) ? $options['error-class'] : 'error' ;

        if($this->hasError($name))
        {
            if(!empty($options['class']))
            {
                $options['class'] .= ' '. $errorClass;

                return $options;
            }
            $options['class'] = $errorClass;
        }
        return $options;
    }

    /**
     * Create a checkable input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     * @param  array  $options
     * @return string
     */
    protected function checkable($type,$name,$value,$checked,$options)
    {
        $options = $this->addErrorClass($name,$options);
        $options = $this->checkRequired($name,$options);

        return parent::checkable($type,$name,$value,$checked,$options);
    }

    /**
     * Check if field is required
     *
     * @param $name
     * @param $options
     * @return mixed
     */
    protected function checkRequired($name,$options)
    {
        if(!empty($options['required']) && $options['required'] && !empty($options['rules']))
        {
            $this->requiredFields[$name] = $options['rules'];

            unset($options['required']);
            unset($options['rules']);
            unset($options['error-class']);
        }
        return $options;
    }

    /**
     * Get all the required fields
     *
     * @return array
     */
    protected function getRequiredFields()
    {
        return $this->requiredFields;
    }

}