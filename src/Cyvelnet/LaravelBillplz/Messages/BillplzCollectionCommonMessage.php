<?php

namespace Cyvelnet\LaravelBillplz\Messages;

use Cyvelnet\LaravelBillplz\BillplzPayment;
use Cyvelnet\LaravelBillplz\Contracts\Submitable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

/**
 * Class BillplzCollectionCommonMessage.
 */
abstract class BillplzCollectionCommonMessage implements Arrayable, Submitable
{
    /**
     * @var
     */
    protected $title;

    /**
     * @var array
     */
    protected $split_payment = [];

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return Arr::get($this->split_payment, 'email');
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->split_payment['email'] = $email;
    }

    /**
     * @return int|null
     */
    public function getFixedCut()
    {
        return Arr::get($this->split_payment, 'fixed_cut');
    }

    /**
     * @param int $fixed_cut
     */
    public function setFixedCut($fixed_cut)
    {
        if ($fixed_cut > 0) {
            $this->split_payment['fixed_cut'] = $fixed_cut * BillplzPayment::BILLPLZ_CONVERSION_RATE;
        }
    }

    /**
     * @return int|null
     */
    public function getVariableCut()
    {
        return Arr::get($this->split_payment, 'variable_cut');
    }

    /**
     * @param int $variable_cut
     */
    public function setVariableCut($variable_cut)
    {
        if ($variable_cut > 0 and $variable_cut <= 100) {
            $this->split_payment['variable_cut'] = $variable_cut;
        }
    }

    /**
     * enable fixed cut split payment.
     *
     * @param string $email  The email address of the split payment’s recipient. (The account must be a verified account.)
     * @param int    $amount A positive integer in the smallest currency unit that is going in your account
     *
     * @return $this
     */
    public function setSplitPaymentByFixed($email, $amount)
    {
        $this->setEmail($email);
        $this->setFixedCut($amount);
    }

    /**
     * enable variable split payment.
     *
     * @param string $email  The email address of the split payment’s recipient. (The account must be a verified account.)
     * @param int    $amount Percentage in positive integer format that is going in your account.
     *
     * @return $this
     */
    public function setSplitPaymentByVariable($email, $amount)
    {
        $this->setEmail($email);
        $this->setVariableCut($amount);
    }

    /**
     * get split payment info.
     *
     * @return array
     */
    public function getSplitPaymentInfo()
    {
        return $this->split_payment;
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
}
