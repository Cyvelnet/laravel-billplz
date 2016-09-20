<?php

namespace Cyvelnet\LaravelBillplz;

use Closure;
use Cyvelnet\LaravelBillplz\Channels\BillChannel;
use Cyvelnet\LaravelBillplz\Contracts\BillplzPaymentInterface;
use Cyvelnet\LaravelBillplz\Contracts\TransportInterface;
use Cyvelnet\LaravelBillplz\Messages\BillMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\CollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\OpenCollectionMessage;
use Illuminate\Support\Str;

/**
 * Class BillplzPayment.
 */
class BillplzPayment implements BillplzPaymentInterface
{
    /**
     * billplz conversion rate, they take 100 as RM 1.
     */
    const BILLPLZ_CONVERSION_RATE = 100;
    /**
     * @var \Cyvelnet\LaravelBillplz\Contracts\TransportInterface
     */
    protected $transport;

    /**
     * @var
     */
    protected $collectionId;

    /**
     * @var
     */
    protected $callbackUrl;

    /**
     * @var array
     */
    protected $references = [];
    /**
     * @var string
     */
    private $logo;
    /**
     * @var string
     */
    private $photo;

    /**
     * create a new billplz service bill.
     *
     * @param \Closure $bill
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function issue(Closure $bill)
    {
        $message = $this->createMessage();

        return $this->buildMessage($bill, $message);
    }

    /**
     * create a new billplz service bill with reusable bill component.
     *
     * @param \Cyvelnet\LaravelBillplz\BillplzPaymentBill|\Closure $bill
     *
     * @return \Cyvelnet\LaravelBillplz\Channels\BillChannel
     */
    public function send(BillplzPaymentBill $bill)
    {
        $message = $this->createMessage();

        return $this->buildMessage($bill, $message);
    }

    /**
     * get a bill from billplz payment gateway.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function get($billId)
    {
        return $this->transport->getBill($billId);
    }

    /**
     * delete a bill from billplz collection.
     *
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function delete($billId)
    {
        return $this->transport->deleteBill($billId);
    }

    /**
     * create a collection.
     *
     * @param string $title
     * @param \Closure $callback
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function collection($title, \Closure $callback = null)
    {
        $collectionMsg = $this->createCollectionMessage();

        $collectionMsg->title($title);

        if ($callback and $callback instanceof Closure) {
            call_user_func($callback, $collectionMsg);
        }

        return $this->transport->createCollection($collectionMsg->getBillplzCollectionMessage());
    }

    /**
     * create an open collection.
     *
     * @param string $title
     * @param string $description
     * @param int|\Closure $amount
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    public function openCollection($title, $description, $amount)
    {
        $collectionMsg = $this->createOpenCollectionMessage();

        $collectionMsg->title($title)->description($description);

        if ($amount and $amount instanceof Closure) {
            call_user_func($amount, $collectionMsg);
        } else {
            $collectionMsg->amount($amount);
        }


        return $this->transport->createOpenCollection($collectionMsg->getBillplzCollectionMessage());
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\BillMessage
     */
    private function createMessage()
    {
        $message = new BillMessage(new BillplzMessage());

        if ($this->collectionId) {
            $message->collectionId($this->collectionId);
        }
        if ($this->callbackUrl) {
            $message->callbackUrl($this->callbackUrl);
        }
        if ($this->references) {
            $reference1 = $this->references[0];
            $reference2 = $this->references[1];


            $message->reference1Label($reference1['label']);
            $message->reference1($reference1['reference']);
            $message->reference2Label($reference2['label']);
            $message->reference2($reference2['reference']);
        }

        return $message;
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\CollectionMessage
     */
    private function createCollectionMessage()
    {
        $message = new CollectionMessage(new BillplzCollectionMessage());

        if ($this->logo) {
            $message->logo($this->logo);
        }

        return $message;
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\OpenCollectionMessage
     */
    private function createOpenCollectionMessage()
    {
        $message = new OpenCollectionMessage(new BillplzOpenCollectionMessage());


        if ($this->photo) {
            $message->photo($this->photo);
        }

        return $message;
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\BillplzPaymentBill|\Closure $bill
     * @param \Cyvelnet\LaravelBillplz\Messages\BillMessage $message
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse|\Cyvelnet\LaravelBillplz\Channels\BillChannel
     */
    private function buildMessage($bill, $message)
    {
        if ($bill instanceof BillplzPaymentBill) {
            foreach ($bill->bill() as $key => $property) {
                $key = Str::camel($key);

                if (method_exists($message, $key)) {
                    $message->{$key}($property);
                }
            }

            return new BillChannel($message->getBillplzMessage(), $this->transport);
        }

        if ($bill instanceof Closure) {
            call_user_func($bill, $message);

            return $this->transport->createBill($message->getBillplzMessage());
        }
    }

    /**
     * set default bill properties.
     *
     * @param $collectionId
     * @param $callbackUrl
     * @param array $references
     */
    public function defaultBills($collectionId, $callbackUrl, $references = [])
    {
        $this->collectionId = $collectionId;
        $this->callbackUrl = $callbackUrl;
        $this->references = $references;
    }

    /**
     * set default collection properties.
     *
     * @param $logo
     * @param $photo
     */
    public function defaultCollections($logo, $photo)
    {
        $this->logo = $logo;
        $this->photo = $photo;
    }

    /**
     * @param $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }
}
