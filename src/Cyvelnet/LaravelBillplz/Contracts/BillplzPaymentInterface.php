<?php

namespace Cyvelnet\LaravelBillplz\Contracts;

use Closure;
use Cyvelnet\LaravelBillplz\BillplzPaymentBill;

/**
 * Interface BillplzPaymentInterface.
 */
interface BillplzPaymentInterface
{
    /**
     * create a new billplz service bill.
     *
     * @param \Closure $bill
     *
     * @return \Cyvelnet\LaravelBillplz\Response\PaymentResponse
     */
    public function issue(Closure $bill);

    /**
     * create a new billplz service bill with reusable bill component.
     *
     * @param \Cyvelnet\LaravelBillplz\BillplzPaymentBill $bill
     *
     * @return \Cyvelnet\LaravelBillplz\BillChannel
     */
    public function send(BillplzPaymentBill $bill);

    /**
     * get a bill from billplz payment gateway.
     *
     * @param string|int billId
     *
     * @return \stdClass
     */
    public function get($billId);

    /**
     * delete a bill from billplz collection.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function delete($billId);

    /**
     * create a collection.
     *
     * @param string   $title
     * @param \Closure $callback
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function collection($title, \Closure $callback = null);

    /**
     * create an open collection.
     *
     * @param string       $title
     * @param string       $description
     * @param int|\Closure $amount
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function openCollection($title, $description, $amount);
}
