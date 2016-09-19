<?php

namespace Cyvelnet\LaravelBillplz\Messages;

/**
 * Class BillMessage.
 */
class BillMessage
{
    /**
     * billplz take 1 cent as an unit
     * which mean RM 1 = 100.
     */


    /*collection_id 	The collection ID. A string.
    email 	The email address of the bill’s recipient. (Email is required if mobile is not present.)
    mobile 	Recipient’s mobile number. Format is +601XXXXXXXX OR 601XXXXXXXX (Mobile is required if email is not present).
    name 	Bill’s recipient name. Useful for identification on recipient part.
    amount 	A positive integer in the smallest currency unit (e.g 100 cents to charge RM 1.00)
    callback_url 	Web hook URL to be called after payment’s transaction completed. It will POST a Bill object.
    description 	The bill's description. Will be displayed on bill template. String format. (Max of 200 characters)
    Optional Arguments
    Parameter 	Description
    due_at 	Due date for the bill. The format YYYY-MM-DD, default value is today.
    redirect_url 	URL to redirect the customer after payment completed. It will do a GET to redirect_url together with bill’s status and ID.
    deliver 	Boolean value to set email and SMS (if mobile is present) delivery. Default value is false.
    reference_1_label 	Label #1 to reconcile payments (Max of 120 characters)
    Default value is Reference 1
    reference_1 	Value for reference_1_label (Max of 20 characters)
    reference_2_label 	Label #2 to reconcile payments (Max of 120 characters)
    Default value is Reference 2
    reference_2 	Value for reference_2_label (Max of 20 characters)*/
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
    public function referenceLabel1($referenceLabel1)
    {
        $this->message->setReferenceLabel1($referenceLabel1);

        return $this;
    }

    /**
     * @param $reference
     *
     * @return $this
     */
    public function reference($reference)
    {
        $this->message->setReference($reference);

        return $this;
    }

    /**
     * @param $referenceLabel2
     *
     * @return $this
     */
    public function referenceLabel2($referenceLabel2)
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
     */
    public function to($name, $email, $mobile = null)
    {
        $this->message->setName($name);
        $this->message->setEmail($email);

        if ($mobile) {
            $this->message->setMobile($mobile);
            $this->message->setDeliver(true);
        }
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\BillplzMessage
     */
    public function getBillplzMessage()
    {
        return $this->message;
    }
}
