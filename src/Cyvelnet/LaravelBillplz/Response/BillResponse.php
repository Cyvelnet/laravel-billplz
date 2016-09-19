<?php

namespace Cyvelnet\LaravelBillplz\Response;

/**
 * Class PaymentResponse.
 */
class BillResponse extends BillplzCommonResponse
{
    /*"id": "8X0Iyzaw",
    "collection_id": "inbmmepb",
    "paid": false,
    "state": "due",
    "amount": 200 ,
    "paid_amount": 0,
    "due_at": "2020-12-31",
    "email" :"api@billplz.com",
    "mobile": "+60112223333",
    "name": "MICHAEL API V3",
    "url": "https://www.billplz.com/bills/8X0Iyzaw",
    "reference_1_label": "First Name",
    "reference_1": Jordan,
    "reference_2_label": "Last Name",
    "reference_2": Michael,
    "redirect_url": "http://example.com/redirect/",
    "callback_url": "http://example.com/webhook/",
    "description": "Maecenas eu placerat ante."*/

    /**
     * BillResponse constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * determine a payment has been made.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->getRawBillplzResponse(false)->paid == true;
    }
}
