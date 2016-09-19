<?php

namespace Cyvelnet\LaravelBillplz\Messages;

use Cyvelnet\LaravelBillplz\BillplzPayment;
use Illuminate\Support\Str;

/**
 * Class BillplzOpenCollectionMessage.
 */
class BillplzOpenCollectionMessage extends BillplzCollectionCommonMessage
{
    /**
     * @var string
     */
    protected $description;

    /**
     * set a default of RM 0.01 which is 1 cents.
     *
     * @var int
     */
    protected $amount = 1;

    /**
     * @var bool
     */
    protected $fixed_amount = true;

    /**
     * @var bool
     */
    protected $fixed_quantity = true;

    /**
     * @var string
     */
    protected $payment_button = 'pay';

    /**
     * @var string
     */
    protected $reference_1_label = 'Reference 1';

    /**
     * @var string
     */
    protected $reference_2_label = 'Reference 2';

    /**
     * @var string
     */
    protected $email_link;

    /**
     * @var int|float
     */
    protected $tax;

    /**
     * @var string
     */
    protected $photo;

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $title = Str::limit($title, 50, '');
        parent::setTitle($title);
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
        $this->description = $title = Str::limit($description, 200, '');
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        if ($amount > 0) {
            $this->amount = $amount * BillplzPayment::BILLPLZ_CONVERSION_RATE;
        }
    }

    /**
     * @return bool
     */
    public function isFixedAmount()
    {
        return $this->fixed_amount;
    }

    /**
     * @param bool $fixed_amount
     */
    public function setFixedAmount($fixed_amount = false)
    {
        $this->fixed_amount = var_export($fixed_amount, true);
    }

    /**
     * @return bool
     */
    public function isFixedQuantity()
    {
        return $this->fixed_quantity;
    }

    /**
     * @param bool $fixed_quantity
     */
    public function setFixedQuantity($fixed_quantity = false)
    {
        $this->fixed_quantity = var_export($fixed_quantity, true);
    }

    /**
     * @return string
     */
    public function getPaymentButton()
    {
        return $this->payment_button;
    }

    /**
     * Payment button's text. Available options are "buy" and "pay". Default value is pay.
     *
     * @param string $payment_button
     */
    public function setPaymentButton($payment_button = 'pay')
    {
        if (in_array($payment_button, ['buy', 'pay'])) {
            $this->payment_button = $payment_button;
        }
    }

    /**
     * @return string
     */
    public function getReference1Label()
    {
        return $this->reference_1_label;
    }

    /**
     * @param string $reference_1_label
     */
    public function setReference1Label($reference_1_label)
    {
        $this->reference_1_label = $reference_1_label;
    }

    /**
     * @return string
     */
    public function getReference2Label()
    {
        return $this->reference_2_label;
    }

    /**
     * @param string $reference_2_label
     */
    public function setReference2Label($reference_2_label)
    {
        $this->reference_2_label = $reference_2_label;
    }

    /**
     * @return string
     */
    public function getEmailLink()
    {
        return $this->email_link;
    }

    /**
     * @param string $email_link
     */
    public function setEmailLink($email_link)
    {
        $this->email_link = $email_link;
    }

    /**
     * @return int|float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param int|float $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * This image will be resized to retina (Yx960) and avatar (180x180) dimensions. Whitelisted formats are jpg, jpeg, gif and png.
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * get guzzle friendly submittable array.
     *
     * @return array
     */
    public function toForm()
    {
        $params = $this->toArray();

        if (array_key_exists('photo', $params) and $params['photo']) {
            $params['photo'] = @fopen($params['photo'], 'r');
        }

        return array_filter($params, function ($param) {
            return $param !== '' or !is_null($param);
        });
    }
}
