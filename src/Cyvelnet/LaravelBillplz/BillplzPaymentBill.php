<?php

namespace Cyvelnet\LaravelBillplz;

/**
 * Class BillplzPaymentBill.
 */
abstract class BillplzPaymentBill
{
    /**
     * define bill properties.
     *
     * @return array
     */
    abstract public function bill();
}
