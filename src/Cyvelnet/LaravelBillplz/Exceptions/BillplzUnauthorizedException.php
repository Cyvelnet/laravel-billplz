<?php

namespace Cyvelnet\LaravelBillplz\Exceptions;

/**
 * Class BillplzUnauthorizedException.
 */
class BillplzUnauthorizedException extends \Exception
{
    /**
     * BillplzUnauthorizedException constructor.
     */
    public function __construct()
    {
        parent::__construct('Please ensure you have proper configured billplz service.');
    }
}
