# Facades/TMGBlade.php

Overview

`TMGBlade` is a Laravel facade that exposes the `TMGBladeHelper` instance, enabling Blade and application code to call helper methods like `renderHeader()` and `renderSlot()` via the `TMGBlade` facade.

Class: TNLMedia\LaravelTool\Facades\TMGBlade

Usage

- `TMGBlade::renderHeader()` - returns header HTML with analytics and advertising bootstrap.
- `TMGBlade::renderSlot($name, $config = [])` - returns an ad slot HTML fragment merged with defaults/targeting.

Notes

- The facade's accessor returns the class name `TNLMedia\LaravelTool\Helpers\TMGBladeHelper::class` so the underlying binding should resolve to an instance of that helper.

