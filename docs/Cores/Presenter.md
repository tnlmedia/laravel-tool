# Presenter

`Presenter` is a base class for creating presenter objects that wrap Eloquent models to provide computed or formatted properties.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Presenter`.
2. Set your presenter class name to the model's `$presenter` property.
3. Define methods in your presenter class for any computed or formatted properties you want to expose.

## Tips

### Naming methods

Usually, few rule can help you to name your presenter methods:

- targetObject(): Convert model to fully qualified object.
- targetSummary(): Convert model to summarized array.
- isSomething(): Checking boolean state.

### Using methods

You can access presenter methods like general properties on the presenter instance.

```php
$model = YourModel::find(1);
$formattedValue = $presenter->present()->formattedProperty;
```

Best recommend to use presenter methods as methods, not properties, it's easier to trace and flexible.

```php
$model = YourModel::find(1);
$formattedValue = $presenter->present()->formattedProperty('maybe', 'with', 'parameters');
```
