<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('int_array', function($attribute, $value, $parameters, $validator) {
            $check = function($carry, $item) use ($parameters){
                if (!is_numeric($item))
                    return false;
                $item = +$item;
                return  $carry &&
                        is_int($item) &&
                        (   count($parameters)==0 ||
                            $parameters[0]<=$item && $item<=$parameters[1]);
            };

            return (is_array($value) and array_reduce($value,$check,true));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
