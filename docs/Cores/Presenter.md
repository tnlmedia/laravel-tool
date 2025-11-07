# Presenter

`Presenter` is a base class for creating presenter objects that wrap Eloquent models and provide computed or formatted properties.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Presenter`.
2. Set your presenter class name on the model's `$presenter` property.
3. Define methods in your presenter class for any computed or formatted properties you want to expose.

## Tips

### Naming methods

A few rules can help you name your presenter methods:

- `targetObject()`: Convert the model to a fully qualified object.
- `targetSummary()`: Convert the model to a summarized array.
- `isSomething()`: Check boolean state.

### Using methods

You can access presenter methods like general properties via the presenter instance.

```php
$model = YourModel::find(1);
$formattedValue = $model->present()->formattedProperty;
```

It is recommended to call presenter methods (rather than accessing them as properties); this is easier to trace and more flexible.

```php
$model = YourModel::find(1);
$formattedValue = $model->present()->formattedProperty('maybe', 'with', 'parameters');
```
