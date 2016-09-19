<?php

namespace Cyvelnet\LaravelBillplz\Exceptions;

/**
 * Class EndpointNotFoundException.
 */
class EndpointNotFoundException extends \Exception
{
    /**
     * EndpointNotFoundException constructor.
     */
    public function __construct($url)
    {
        $message = "The endpoint {$url} is not found.";

        parent::__construct($message, 404);
    }
}
