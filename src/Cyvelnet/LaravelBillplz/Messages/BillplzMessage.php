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
    private $collection_id;

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
    private $callback_url;

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
    private $redirect_url;

    /**
     * @var bool
     */
    private $deliver = false;

    /**
     * @var string
     */
    private $reference_1_label = 'Reference 1';

    /**
     * @var string
     */
    private $reference_1;

    /**
     * @var string
     */
    private $reference_2_label = 'Reference 2';

    /**
     * @var string
     */
    private $reference_2;

    /**
     * @return string
     */
    public function getCollectionId()
    {
        return $this->collection_id;
    }

    /**
     * @param string $collection_id
     */
    public function setCollectionId($collection_id)
    {
        $this->collection_id = $collection_id;
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
        return $this->callback_url;
    }

    /**
     * @param string $callback_url
     */
    public function setCallbackUrl($callback_url)
    {
        $this->callback_url = $callback_url;
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
        return $this->redirect_url;
    }

    /**
     * @param string $redirect_url
     */
    public function setRedirectUrl($redirect_url)
    {
        $this->redirect_url = $redirect_url;
    }

    /**
     * @return bool
     */
    public function isDeliver()
    {
        return ($this->deliver === true OR $this->deliver === 'true') ;
    }

    /**
     * @param bool|string $deliver
     */
    public function setDeliver($deliver)
    {
        $this->deliver = var_export($deliver, true);
    }

    /**
     * @return string
     */
    public function getReferenceLabel1()
    {
        return $this->reference_1_label;
    }

    /**
     * @param string $reference_1_label
     */
    public function setReferenceLabel1($reference_1_label)
    {
        $this->reference_1_label = Str::limit($reference_1_label, 120, '');
    }

    /**
     * @return string
     */
    public function getReference1()
    {
        return $this->reference_1;
    }

    /**
     * @param string $reference1
     */
    public function setReference($reference1)
    {
        $this->reference_1 = Str::limit($reference1, 20, '');
    }

    /**
     * @return string
     */
    public function getReferenceLabel2()
    {
        return $this->reference_2_label;
    }

    /**
     * @param string $reference_2_label
     */
    public function setReferenceLabel2($reference_2_label)
    {
        $this->reference_2_label = Str::limit($reference_2_label, 120, '');
    }

    /**
     * @return string
     */
    public function getReference2()
    {
        return $this->reference_2;
    }

    /**
     * @param string $reference_2
     */
    public function setReference2($reference_2)
    {
        $this->reference_2 = Str::limit($reference_2, 20, '');
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
