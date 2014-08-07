Laravel form validation helper
===============================

A helper to easy validate laravel forms.

Installation
============

Add `artisaninweb/laravel-formvalidation-helper` as requirement to composer.json

```javascript
{
    "require": {
        "artisaninweb/laravel-formvalidation-helper": "0.1.*"
    }
}
```

Replace `'Illuminate\Html\HtmlServiceProvider'` with `'Artisaninweb\FormValidationHelper\ServiceProvider'`

Replace in aliases `'Form' => 'Illuminate\Support\Facades\Form'` with `'Form' => 'Artisaninweb\FormValidationHelper\Facades\Form'`

Usage
============

The parameters to use:

`required` (bool): Make the field required.<br />
`rules` (string): Specify the rules of the validation.<br />
`error-class` (string): Add a custom class to the form field on error (optional, default: 'error').

```php
Form::text('field-name','field-value',[required' => true, 'rules' => 'required|email', 'error-class' => 'form-error']);
```

To output the error you can place this in your view.<br />
Default the error wil come from the validator, you can edit this in `/app/lang/{lang}/validation.php`.

```php
// Replace the error with you own.
Form::error('field-name','<p>You can put a custom html error here.</p>');

// Only replace the html tags
Form::error('field-name','<p>:message</p>');
```

Example:

```php
echo Form::open(['url' => '/login']);
echo Form::text('email', '', ['required' => true, 'rules' => 'required|email', 'error-class' => 'form-error']);
echo Form::error('email', '<p>This field is required.</p>');
echo Form::password('password', '', ['required' => true, 'rules' => 'required|min:8', 'error-class' => 'form-error']);
echo Form::error('password', '<p>This field is required.</p>');
echo Form::submit('Login');
echo Form::close();
```

After a form submit you can validate the last submitted form.

```php
Form::validate(function($postData,$passes,$messages) {
    var_dump($postData);
    var_dump($passes);
    var_dump($messages);
});
```

TwigBridge
============

If you are using `https://github.com/rcrowe/TwigBridge` as TwigBirdge in Laravel (like i do).<br />
You can replace `'TwigBridge\Extension\Laravel\Form'` with `'Artisaninweb\FormValidationHelper\Extension\TwigBridgeForm'`.<br />
You will find this in `app/config/packages/rcrowe/twigbridge/extensions`.