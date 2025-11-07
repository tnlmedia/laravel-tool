# ModelOrm

`ModelOrm` provides a base Eloquent model with standardized defaults and presenter support.

## How to use

1. Create your domain model and extend `TNLMedia\LaravelTool\Cores\ModelOrm`.
2. Set basic properties as needed (e.g., `$table`, `$fillable`).
3. Optionally create a `Presenter` subclass for view-specific logic.

## Properties

Most properties are inherited from `Illuminate\Database\Eloquent\Model` and provide defaults suitable for common applications.

## Presenter

The model includes presenter support via the `present()` method, which returns a cached `Presenter` instance for the model.

You do not need an external presenter package to use this feature.
