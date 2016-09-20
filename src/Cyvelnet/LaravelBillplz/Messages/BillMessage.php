<?php

namespace Cyvelnet\LaravelBillplz\Messages;

/**
 * Class BillMessage.
 */
class BillMessage
{
    /**
     * @var
     */
    protected $message;

    /**
     * Bill constructor.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @param $collectionId
     *
     * @return $this
     */
    public function collectionId($collectionId)
    {
        $this->message->setCollectionId($collectionId);

        return $this;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function email($email)
    {
        $this->message->setEmail($email);

        return $this;
    }

    /**
     * @param $mobile
     *
     * @return $this
     */
    public function mobile($mobile)
    {
        $this->message->setMobile($mobile);
        $this->message->setDeliver(true);

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->message->setName($name);

        return $this;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function amount($amount)
    {
        $this->message->setAmount($amount);

        return $this;
    }

    /**
     * @param $callbackUrl
     *
     * @return $this
     */
    public function callbackUrl($callbackUrl)
    {
        $this->message->setCallbackUrl($callbackUrl);

        return $this;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function description($description)
    {
        $this->message->setDescription($description);

        return $this;
    }

    /**
     * @param $dueAt
     *
     * @return $this
     */
    public function dueAt($dueAt)
    {
        $this->message->setDueAt($dueAt);

        return $this;
    }

    /**
     * @param $redirectUrl
     *
     * @return $this
     */
    public function redirectUrl($redirectUrl)
    {
        $this->message->setRedirectUrl($redirectUrl);

        return $this;
    }

    /**
     * @param bool $deliver
     *
     * @return $this
     */
    public function deliver($deliver = true)
    {
        $this->message->setDeliver($deliver);

        return $this;
    }

    /**
     * @param $referenceLabel1
     *
     * @return $this
     */
    public function reference1Label($referenceLabel1)
    {
        $this->message->setReferenceLabel1($referenceLabel1);

        return $this;
    }

    /**
     * @param $reference
     *
     * @return $this
     */
    public function reference1($reference)
    {
        $this->message->setReference($reference);

        return $this;
    }

    /**
     * @param $referenceLabel2
     *
     * @return $this
     */
    public function reference2Label($referenceLabel2)
    {
        $this->message->setReferenceLabel2($referenceLabel2);

        return $this;
    }

    /**
     * @param $reference2
     *
     * @return $this
     */
    public function reference2($reference2)
    {
        $this->message->setReference2($reference2);

        return $this;
    }

    /**
     * @param $name
     * @param $email
     * @param null $mobile
     *
     * @return $this
     */
    public function to($name, $email, $mobile = null)
    {
        $this->message->setName($name);
        $this->message->setEmail($email);

        if ($mobile) {
            $this->message->setMobile($mobile);
            $this->message->setDeliver(true);
        }

        return $this;
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\BillplzMessage
     */
    public function getBillplzMessage()
    {
        return $this->message;
    }
}
