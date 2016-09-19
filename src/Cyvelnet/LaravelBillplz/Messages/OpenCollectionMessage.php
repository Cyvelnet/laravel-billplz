<?php

namespace Cyvelnet\LaravelBillplz\Messages;

/**
 * Class OpenCollectionMessage.
 */
class OpenCollectionMessage
{
    /**
     * @var \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage
     */
    private $message;

    /**
     * OpenCollectionMessage constructor.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $message
     */
    public function __construct(BillplzOpenCollectionMessage $message)
    {
        $this->message = $message;
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function title($title)
    {
        $this->message->setTitle($title);

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
     * A positive integer in the smallest currency unit
     * Required if fixed_amount is true; Ignored if fixed_amount is false.
     *
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
     * collection open to accept any amount.
     *
     * @return $this
     */
    public function anyAmount()
    {
        $this->message->setAmount(0);
        $this->message->setFixedAmount(false);

        return $this;
    }

    /**
     * Boolean value. Set fixed_amount to false for Open Amount.
     *
     * @param bool $fixedAmount
     *
     * @return $this
     */
    public function fixedAmount($fixedAmount = false)
    {
        $this->message->setFixedAmount($fixedAmount);

        return $this;
    }

    /**
     * collection open to accept any quantity.
     *
     * @return $this
     */
    public function anyQuantity()
    {
        $this->message->setFixedQuantity(false);

        return $this;
    }

    /**
     * Boolean value. Set fixed_quantity to false for Open Quantity.
     *
     * @param bool $fixedQuantity
     *
     * @return $this
     */
    public function fixedQuantity($fixedQuantity = false)
    {
        $this->message->setFixedQuantity($fixedQuantity);

        return $this;
    }

    /**
     * Accept collection with any amount and quantity.
     *
     * @return $this
     */
    public function anyAmountAndQty()
    {
        $this->message->setFixedQuantity();
        $this->message->setFixedAmount();


        return $this;
    }

    /**
     * Payment button's text. Available options are "buy" and "pay". Default value is pay.
     *
     * @param $paymentButtonText
     *
     * @return $this
     */
    public function paymentButton($paymentButtonText = 'pay')
    {
        $this->message->setPaymentButton($paymentButtonText);

        return $this;
    }

    /**
     * Label #1 to reconcile payments (Max of 120 characters)
     * Default value is Reference 1.
     *
     * @param $reference1Label
     *
     * @return $this
     */
    public function reference1($reference1Label = 'Reference 1')
    {
        $this->message->setReference1Label($reference1Label);

        return $this;
    }

    /**
     * Label #2 to reconcile payments (Max of 120 characters)
     * Default value is Reference 2.
     *
     * @param $reference2Label
     *
     * @return $this
     */
    public function reference2($reference2Label = 'Reference 2')
    {
        $this->message->setReference2Label($reference2Label);

        return $this;
    }

    /**
     * A URL that email to customer after payment is successful.
     *
     * @param $emailLink
     *
     * @return $this
     */
    public function emailLink($emailLink)
    {
        $this->message->setEmailLink($emailLink);

        return $this;
    }

    /**
     * Tax rate in positive integer format.
     *
     * @param int|float $tax
     *
     * @return $this
     */
    public function tax($tax)
    {
        $this->message->setTax($tax);

        return $this;
    }

    /**
     * This image will be resized to retina (Yx960) and avatar (180x180) dimensions. Whitelisted formats are jpg, jpeg, gif and png.
     *
     * @param $photo
     *
     * @return $this
     */
    public function photo($photo)
    {
        $this->message->setPhoto($photo);

        return $this;
    }

    /**
     * enable fixed cut split payment.
     *
     * @param string $email  The email address of the split payment’s recipient. (The account must be a verified account.)
     * @param int    $amount A positive integer in the smallest currency unit that is going in your account
     *
     * @return $this
     */
    public function splitPaymentByFixed($email, $amount)
    {
        $this->message->setSplitPaymentByFixed($email, $amount);

        return $this;
    }

    /**
     * enable variable split payment.
     *
     * @param string $email  The email address of the split payment’s recipient. (The account must be a verified account.)
     * @param int    $amount Percentage in positive integer format that is going in your account.
     *
     * @return $this
     */
    public function splitPaymentByVariable($email, $amount)
    {
        $this->message->setSplitPaymentByVariable($email, $amount);

        return $this;
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage
     */
    public function getBillplzCollectionMessage()
    {
        return $this->message;
    }
}
