<?php

namespace Cyvelnet\LaravelBillplz\Response;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class BillplzCommonResponse.
 */
abstract class BillplzCommonResponse implements Jsonable, Arrayable
{
    /**
     * @var \GuzzleHttp\Message\Response|\GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * determine a request is completed and received success response from billplz gateway.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->isSuccessful();
    }

    /**
     * determine a request is completed and received success response from billplz gateway.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return in_array($this->getHttpCode(), [200, 201, 202, 203, 204, 205, 206, 207, 208, 226]);
    }

    /**
     * get billplz response http code.
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * get request error message.
     *
     * @return array
     */
    public function getError()
    {
        $raw = $this->getRawBillplzResponse(false);

        if (isset($raw) and array_key_exists('error', $raw)) {
            return $raw->error;
        }

        return [];
    }

    /**
     * get raw json response from billplz gateway.
     *
     * @param bool $assoc
     *
     * @return mixed|array
     */
    public function getRawBillplzResponse($assoc = true)
    {
        return json_decode($this->response->getBody()->getContents(), $assoc);
    }

    /**
     * set response.
     *
     * @param $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->response->getBody()->getContents(), true);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_decode($this->response->getBody()->getContents(), $options);
    }
}
