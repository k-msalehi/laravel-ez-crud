ez-crud forked from [mehradsadeghi/laravel-crud-generator](https://github.com/mehradsadeghi/laravel-crud-generator).  
Thank you [mehradsadeghi](https://github.com/mehradsadeghi) for your efforts.

# What's changed
Now you can add `--views` option to create related views,  
e.g. `php artisan make:crud UserController --model=User --views`  
*Created view files are based on bootstrap 5*

By defualt, view files extends from `layouts.app`; To customize them you can use  
`php artisan vendor:publish --provider="KMsalehi\LaravelEzCrud\EzCrudServiceProvider"`


# Laravel EzCrud
Generate a CRUD scaffold like a breeze.

*Compatible with Laravel **7.x** **8.x** **9.x** **10.x***.

### Installation
`$ composer require k-msalehi/laravel-ez-crud --dev`

### Usage
It works based on your `$fillable` property of the target model.

If you would like to use `$guarded` instead of `$fillable`, It is supported too. 
In that case you'll need to have an existing `Schema` (table), Then the crud generator will automatically figures out your fillables.

As an example when `$fillable` is available:

`$ php artisan make:crud UserController --model=User --validation`

![laravel-crud-generator](https://user-images.githubusercontent.com/31504728/92512225-b99be400-f223-11ea-84ba-bbfb55d1babd.gif)

#### Customizing Stubs
You can modify default stubs by publishing them:

`$ php artisan crud:publish`

The published stubs will be located within `stubs/crud` directory in the root of your application.
Any changes you make to these stubs will be reflected when you generate crud.

----------------------------------------------

### Your Stars Matter ⭐️

