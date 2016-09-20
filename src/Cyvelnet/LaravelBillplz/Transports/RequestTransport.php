<?php

namespace Cyvelnet\LaravelBillplz\Transports;

use Cyvelnet\LaravelBillplz\Contracts\BillplzApiTransport as BillplzApiTransportContract;
use Cyvelnet\LaravelBillplz\Contracts\TransportInterface;
use Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage;

/**
 * Class RequestTransport.
 */
class RequestTransport implements TransportInterface
{
    /**
     * @var \Cyvelnet\LaravelBillplz\Contracts\BillplzApiTransport
     */
    private $transport;

    /**
     * RequestTransport constructor.
     *
     * @param \Cyvelnet\LaravelBillplz\Contracts\BillplzApiTransport $transport
     */
    public function __construct(BillplzApiTransportContract $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $bill
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse|mixed
     */
    public function createBill(BillplzMessage $bill)
    {
        return $this->transport->sendCreateBillRequest($bill);
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
        return $this->transport->sendGetBillRequest($billId);
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
        return $this->transport->sendDeleteBillRequest($billId);
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\\Response\CollectionResponse
     */
    public function createCollection(BillplzCollectionMessage $collection)
    {
        return $this->transport->sendCreateCollectionRequest($collection);
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\\Response\CollectionResponse
     */
    public function createOpenCollection(BillplzOpenCollectionMessage $collection)
    {
        return $this->transport->sendCreateOpenCollectionRequest($collection);
    }
}
