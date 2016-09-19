<?php

namespace Cyvelnet\LaravelBillplz\Transports;

use Cyvelnet\LaravelBillplz\Contracts\TransportInterface;
use Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage;
use GuzzleHttp\ClientInterface;

/**
 * Class RequestTransport.
 */
class RequestTransport extends BaseTransport implements TransportInterface
{
    /**
     * @var
     */
    protected $apiKey;
    /**
     * @var bool
     */
    protected $sandboxMode;

    const PRODUCTION_HOST_NAME = 'https://www.billplz.com';

    const SANDBOX_HOST_NAME = 'https://billplz-staging.herokuapp.com';

    const CREATE_BILL_URL = '/api/v3/bills';

    const GET_BILL_URL = '/api/v3/bills/';

    const DELETE_BILL_URL = '/api/v3/bills/';

    const CREATE_COLLECTION_URL = '/api/v3/collections';

    const CREATE_OPEN_COLLECTION_URL = '/api/v3/open_collections';

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
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $bill
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse|mixed
     */
    public function createBill(BillplzMessage $bill)
    {
        return $this->sendCreateBillRequest($bill);
    }

    /**
     * retrieve a bill from billplz gateway.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function getBill($billId)
    {
        return $this->sendGetBillRequest($billId);
    }

    /**
     * delete a bill from billplz collection.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse|mixed
     */
    public function deleteBill($billId)
    {
        return $this->sendDeleteBillRequest($billId);
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\\Response\CollectionResponse
     */
    public function createCollection(BillplzCollectionMessage $collection)
    {
        return $this->sendCreateCollectionRequest($collection);
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\\Response\CollectionResponse
     */
    public function createOpenCollection(BillplzOpenCollectionMessage $collection)
    {
        return $this->sendCreateOpenCollectionRequest($collection);
    }
}
