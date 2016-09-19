<?php

namespace Cyvelnet\LaravelBillplz\Messages;

use Cyvelnet\LaravelBillplz\BillplzPayment;
use Cyvelnet\LaravelBillplz\Contracts\Submitable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class BillMessage.
 */
class BillplzMessage implements Arrayable, Submitable
{
    /**
     * @var string
     */
    private $collectionId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int|float
     */
    private $amount;

    /**
     * @var string
     */
    private $callbackUrl;

    /**
     * @var string
     */
    private $description;

    // optional

    /**
     * @var string
     */
    private $due_at;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var bool
     */
    private $deliver = false;

    /**
     * @var string
     */
    private $referenceLabel1 = 'Reference 1';

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $referenceLabel2 = 'Reference 2';

    /**
     * @var string
     */
    private $reference2;

    /**
     * @return string
     */
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @param string $collectionId
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|int $amount
     */
    public function setAmount($amount)
    {
        if ($amount > 0) {
            $this->amount = $amount * BillplzPayment::BILLPLZ_CONVERSION_RATE;
        }
    }

    /**
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @param string $callbackUrl
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = Str::limit($description, 200, '');
    }

    /**
     * @return string
     */
    public function getDueAt()
    {
        return $this->due_at;
    }

    /**
     * @param string $due_at
     */
    public function setDueAt($due_at)
    {
        $this->due_at = $due_at;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return bool
     */
    public function isDeliver()
    {
        return $this->deliver;
    }

    /**
     * @param bool $deliver
     */
    public function setDeliver($deliver)
    {
        $this->deliver = $deliver;
    }

    /**
     * @return string
     */
    public function getReferenceLabel1()
    {
        return $this->referenceLabel1;
    }

    /**
     * @param string $referenceLabel1
     */
    public function setReferenceLabel1($referenceLabel1)
    {
        $this->referenceLabel1 = Str::limit($referenceLabel1, 120, '');
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = Str::limit($reference, 20, '');
    }

    /**
     * @return string
     */
    public function getReferenceLabel2()
    {
        return $this->referenceLabel2;
    }

    /**
     * @param string $referenceLabel2
     */
    public function setReferenceLabel2($referenceLabel2)
    {
        $this->referenceLabel2 = Str::limit($referenceLabel2, 120, '');
    }

    /**
     * @return string
     */
    public function getReference2()
    {
        return $this->reference2;
    }

    /**
     * @param string $reference2
     */
    public function setReference2($reference2)
    {
        $this->reference2 = Str::limit($reference2, 20, '');
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * get guzzle friendly submittable array.
     *
     * @return array
     */
    public function toForm()
    {
        $params = get_object_vars($this);

        return array_filter($params, function ($param) {
            return $param !== '' or !is_null($param);
        });
    }
}
