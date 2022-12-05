# Nova Notification Feed

A Laravel Nova package that enables you to toggle fields on the index of your resource through a standalone action.

![image](https://user-images.githubusercontent.com/571279/205638983-fef96074-bee8-47ae-ad16-427dfebecda0.png)

## Installation

You can install the package into a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require coreproc/nova-toggle-fields
```

## Usage

To use the toggle fields action, you need to first add the `HasToggleableFields` trait to your resource:

```php
use Coreproc\NovaToggleFields\Traits\HasToggleableFields;

class Contact extends Resource
{
    use HasToggleableFields;
    
    .....
}
```

Then add the the `ToggleFields` action class inside the `actions` method along with the parameters:

```php
use Coreproc\NovaToggleFields\Traits\HasToggleableFields;

class Contact extends Resource
{
    use HasToggleableFields;
    
    .....
    
    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new ToggleFields(self::class, $this->indexFields($request))),
        ];
    }
    
    ...
}
```
