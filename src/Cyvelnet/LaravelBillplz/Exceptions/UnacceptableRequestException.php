<?php

namespace Cyvelnet\LaravelBillplz\Exceptions;

/**
 * Class IncompleteRequestException.
 */
class UnacceptableRequestException extends \Exception
{
    /**
     * IncompleteRequestException constructor.
     *
     * @param array|string $message
     * @param int          $code
     * @param \Exception   $previous
     */
    public function __construct($message = '', $code = 422, \Exception $previous = null)
    {
        $message = implode(", \r\n", $message);
        parent::__construct($message, $code, $previous);
    }
}
