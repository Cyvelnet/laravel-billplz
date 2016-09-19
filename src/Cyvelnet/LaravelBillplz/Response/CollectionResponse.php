<?php

namespace Cyvelnet\LaravelBillplz\Response;

/**
 * Class CollectionResponse.
 */
class CollectionResponse extends BillplzCommonResponse
{
    /**
     * CollectionResponse constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }
}
