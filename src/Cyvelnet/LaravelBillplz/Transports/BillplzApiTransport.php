<?php

namespace Cyvelnet\LaravelBillplz\Transports;

use Cyvelnet\LaravelBillplz\Contracts\BillplzApiTransport as BillplzApiTransportContract;
use Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage;
use GuzzleHttp\ClientInterface;

/**
 * Class BaseTransport.
 */
class BillplzApiTransport extends BillplzApiTransportContract
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $http;

    /**
     * @var
     */
    protected $apiKey;
    /**
     * @var bool
     */
    protected $sandboxMode;

    /**
     * RequestTransport constructor.
     *
     * @param \GuzzleHttp\ClientInterface $http
     * @param $apiKey
     * @param bool $sandboxMode
     */
    public function __construct(ClientInterface $http, $apiKey, $sandboxMode = false)
    {
        $this->http = $http;
        $this->apiKey = $apiKey;
        $this->sandboxMode = $sandboxMode;
    }

    /**
     * send a create bill request.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $message
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function sendCreateBillRequest(BillplzMessage $message)
    {
        $options = $this->buildBillBody($message);

        $url = $this->getRequestUrl(self::CREATE_BILL_URL);

        return $this->sendBill('post', $url, $options);
    }

    /**
     * send a get bill request.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse|mixed
     */
    public function sendGetBillRequest($billId)
    {
        $url = $this->getRequestUrl(self::GET_BILL_URL . $billId);

        return $this->sendBill('get', $url);
    }

    /**
     * send a delete bill request.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function sendDeleteBillRequest($billId)
    {
        $url = $this->getRequestUrl(self::DELETE_BILL_URL . $billId);

        return $this->sendBill('delete', $url);
    }

    /**
     * send a create collection request.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function sendCreateCollectionRequest(BillplzCollectionMessage $collection)
    {
        $options = $this->buildCollectionBody($collection);

        $url = $this->getRequestUrl(self::CREATE_COLLECTION_URL);

        return $this->sendCollection('post', $url, $options);
    }

    /**
     * send a create open collection request.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function sendCreateOpenCollectionRequest(BillplzOpenCollectionMessage $collection)
    {
        $options = $this->buildCollectionBody($collection);

        $url = $this->getRequestUrl(self::CREATE_OPEN_COLLECTION_URL);

        return $this->sendCollection('post', $url, $options);
    }
}
