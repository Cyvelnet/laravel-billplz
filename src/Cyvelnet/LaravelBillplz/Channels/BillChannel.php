<?php

namespace Cyvelnet\LaravelBillplz\Channels;

use Cyvelnet\LaravelBillplz\Contracts\TransportInterface;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;

class BillChannel
{
    /**
     * @var \Cyvelnet\LaravelBillplz\Messages\BillplzMessage
     */
    private $message;
    /**
     * @var \Cyvelnet\LaravelBillplz\Transports\RequestTransport
     */
    private $http;

    /**
     * BillChannel constructor.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage      $message
     * @param \Cyvelnet\LaravelBillplz\Contracts\TransportInterface $http
     */
    public function __construct(BillplzMessage $message, TransportInterface $http)
    {
        $this->message = $message;
        $this->http = $http;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function to($name)
    {
        $this->message->setName($name);

        return $this;
    }

    /**
     * @param $mobile
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function viaSms($mobile)
    {
        $this->message->setMobile($mobile);
        $this->message->setDeliver(true);

        return $this->http->createBill($this->message);
    }

    /**
     * @param $email
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function viaEmail($email)
    {
        $this->message->setEmail($email);

        return $this->http->createBill($this->message);
    }

    /**
     * @param $email
     * @param $mobile
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    public function viaEmailAndSms($email, $mobile)
    {
        $this->message->setEmail($email);
        $this->message->setMobile($mobile);
        $this->message->setDeliver(true);

        return $this->http->createBill($this->message);
    }
}
