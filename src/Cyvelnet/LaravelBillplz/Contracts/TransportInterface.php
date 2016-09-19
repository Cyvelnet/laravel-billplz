<?php

namespace Cyvelnet\LaravelBillplz\Contracts;

use Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage;

/**
 * Interface TransportInterface.
 */
interface TransportInterface
{
    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $bill
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function createBill(BillplzMessage $bill);

    /**
     * @param $billId
     *
     * @return \stdClass
     */
    public function getBill($billId);

    /**
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function deleteBill($billId);

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function createCollection(BillplzCollectionMessage $collection);

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function createOpenCollection(BillplzOpenCollectionMessage $collection);
}
