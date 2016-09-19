<?php

namespace Cyvelnet\LaravelBillplz\Exceptions;

/**
 * Class TemporarilyServiceUnavailableException.
 */
class TemporarilyServiceUnavailableException extends \Exception
{
    /**
     * TemporarilyServiceUnavailableException constructor.
     */
    public function __construct()
    {
        parent::__construct('Billplz payment gateway is temporarily unavailable, please try again later.', 500);
    }
}
