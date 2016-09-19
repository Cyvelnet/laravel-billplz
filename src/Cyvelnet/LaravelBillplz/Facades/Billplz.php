<?php

namespace Cyvelnet\LaravelBillplz\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Billplz.
 */
class Billplz extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'billplz';
    }
}
