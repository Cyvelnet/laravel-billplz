<?php

namespace Cyvelnet\LaravelBillplz\Messages;

/**
 * Class CollectionMessage.
 */
class CollectionMessage
{
    //    /**
//     * @param $title
//     *
//     * @return $this
//     */
//    public function title($title)
//    {
//        $this->setTitle($title);
//        return $this;
//    }
    /**
     * @var \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage
     */
    private $message;

    /**
     * CollectionMessage constructor.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage $message
     */
    public function __construct(BillplzCollectionMessage $message)
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
     * @param $logo
     *
     * @return $this
     */
    public function logo($logo)
    {
        $this->message->setLogo($logo);

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
     * @param $variable_cut
     *
     * @return $this
     */
    public function variableCut($variable_cut)
    {
        $this->message->setVariableCut($variable_cut);

        return $this;
    }

    /**
     * @param $fixed_cut
     *
     * @return $this
     */
    public function fixedCut($fixed_cut)
    {
        $this->message->setFixedCut($fixed_cut);

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
     * @return \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage
     */
    public function getBillplzCollectionMessage()
    {
        return $this->message;
    }
}
