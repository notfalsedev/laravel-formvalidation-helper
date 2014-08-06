Laravel form validation helper
===============================

A helper to easy validate laravel forms.

Installation
============

Add `artisaninweb/laravel-formvalidation-helper` as requirement to composer.json

```javascript
{
    "require": {
        "artisaninweb/laravel-formvalidation-helper": "0.1"
    }
}
```

Replace `'Illuminate\Html\HtmlServiceProvider'` with `'Artisaninweb\FormValidationHelper\ServiceProvider'`

Replace in aliases `'Form' => 'Illuminate\Support\Facades\Form'` with `'Form' => 'Artisaninweb\FormValidationHelper\Facade'`

Usage
============

Add 2 parameters to the form attributes `required` and `rules`.

```php
echo Form::open(['url' => '/contact']);
echo Form::text('username','',array('required'=>true, 'rules' => 'required'));
echo Form::text('password','',array('required' => true, 'rules' => 'required'));
echo Form::submit('Click Me!');
echo Form::close();
```

After a form submit you can validate the last submitted form.

```php
Form::validate(function($passes,$messages){
    var_dump($passes);
    var_dump($messages);
});
```

TwigBridge
============

If you are using `https://github.com/rcrowe/TwigBridge` as TwigBirdge in Laravel (like i do).<br />
You can replace `'TwigBridge\Extension\Laravel\Form'` with `'Artisaninweb\FormValidationHelper\Extension\TwigBridgeForm'`.<br />
You find this in `app/config/packages/rcrowe/twigbridge/extensions`.