<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelVonageDlrWebhooks extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-vonage-dlr-webhooks';
    }
}
