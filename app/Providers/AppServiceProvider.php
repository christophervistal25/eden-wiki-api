<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot()
    {

        app('validator')->extend('json_effect', function ($attribute, $effects) {

            if (!empty(json_decode($effects))) {

                foreach (json_decode($effects) as $effect) {
                    if (Str::contains($effect->no_of_parts, '/')) {
                        list($noOfPartsRequire) = explode('/', $effect->no_of_parts);
                        if ((int) $noOfPartsRequire == 0) {
                            return false;
                        }
                    } else {
                        return false;
                    }

                    if (empty($effect->attribute)) {
                        return false;
                    }

                    if (empty($effect->attribute_value)) {
                        return false;
                    }
                }

                // If all the validation test passed
                return true;
            }

            return false;
        });
        app('validator')->replacer('json_effect', function ($message, $attribute, $rule, $parameters) {
            return 'Please check all fields in set effects.';
        });


        app('validator')->extend('json_item', function ($attribute, $parts) {
            if (!empty(json_decode($parts))) {

                $noOfId = 0;
                foreach (json_decode($parts) as  $item) {
                    if (isset($item->id)) {
                        $noOfId++;
                    }
                }

                return $noOfId >= 4;
            }

            return false;
        });
        app('validator')->replacer('json_item', function ($message, $attribute, $rule, $parameters) {
            return 'Selected parts must be minimum of 4 items.';
        });
    }
}
