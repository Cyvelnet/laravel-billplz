<?php

/**
 * Class CollectionTest
 */
class CollectionTest extends Orchestra\Testbench\TestCase
{

    /**
     * @test
     */
    public function it_should_set_split_payment_by_fixed_and_split_email()
    {
        $message = $this->getCollectionMessage();
        $message->splitPaymentByFixed('foo@bar.com', 50);

        $this->assertSame([
            'email'     => 'foo@bar.com',
            'fixed_cut' => 50 * 100,
        ], $message->getBillplzCollectionMessage()->getSplitPaymentInfo());
    }

    /**
     * @test
     */
    public function it_should_set_split_payment_by_variable_and_split_email()
    {
        $message = $this->getCollectionMessage();
        $message->splitPaymentByVariable('foo@bar.com', 20);

        $this->assertSame([
            'email'        => 'foo@bar.com',
            'variable_cut' => 20,
        ], $message->getBillplzCollectionMessage()->getSplitPaymentInfo());
    }

    /**
     * @test
     */
    public function it_should_able_to_set_collection_values_correctly()
    {
        $message = $this->getCollectionMessage();

        $message->title('collection title')
            ->logo('logo.jpg')
            ->splitPaymentByFixed('foo@bar.com', 100);

        $this->assertSame([

            'logo'          => 'logo.jpg',
            'title'         => 'collection title',
            'split_payment' => [
                'email'     => 'foo@bar.com',
                'fixed_cut' => 100 * 100,
            ],

        ], $message->getBillplzCollectionMessage()->toArray());
    }

    /**
     * @test
     */
    public function it_should_able_to_set_basic_open_collection_values_correctly()
    {
        $message = $this->getOpenCollectionMessage();

        $message->title('collection title')
            ->description('collection description')
            ->amount(50);

        $this->assertSame([

            'description'       => 'collection description',
            'amount'            => 5000,
            'fixed_amount'      => true,
            'fixed_quantity'    => true,
            'payment_button'    => 'pay',
            'reference_1_label' => 'Reference 1',
            'reference_2_label' => 'Reference 2',
            'email_link'        => null,
            'tax'               => null,
            'photo'             => null,
            'title'             => 'collection title',
            'split_payment'     => [

            ],

        ], $message->getBillplzCollectionMessage()->toArray());
    }

    /**
     * @test
     */
    public function it_should_able_to_set_open_collection_to_accept_any_amount_and_qty_correctly()
    {
        $message = $this->getOpenCollectionMessage();

        $message->title('collection title')
            ->description('collection description')
            ->anyAmountAndQty();

        $this->assertSame([

            'description'       => 'collection description',
            'amount'            => 1,                   // required parameter, but billplz will ignore this value automatically, when fixed_amount set to false
            'fixed_amount'      => 'false',
            'fixed_quantity'    => 'false',
            'payment_button'    => 'pay',
            'reference_1_label' => 'Reference 1',
            'reference_2_label' => 'Reference 2',
            'email_link'        => null,
            'tax'               => null,
            'photo'             => null,
            'title'             => 'collection title',
            'split_payment'     => [

            ],

        ], $message->getBillplzCollectionMessage()->toArray());
    }

    /**
     * @test
     */
    public function it_should_able_to_set_open_collection_to_value_correctly()
    {
        $message = $this->getOpenCollectionMessage();

        $message->title('collection title')
            ->description('collection description')
            ->anyAmountAndQty()
            ->paymentButton('buy')
            ->reference1('foo reference')
            ->reference2('bar reference')
            ->emailLink('http://foobar.com')
            ->tax(6)
            ->photo('photo.jpg');

        $this->assertSame([

            'description'       => 'collection description',
            'amount'            => 1,                   // required parameter, but billplz will ignore this value automatically, when fixed_amount set to false
            'fixed_amount'      => 'false',
            'fixed_quantity'    => 'false',
            'payment_button'    => 'buy',
            'reference_1_label' => 'foo reference',
            'reference_2_label' => 'bar reference',
            'email_link'        => 'http://foobar.com',
            'tax'               => 6,
            'photo'             => 'photo.jpg',
            'title'             => 'collection title',
            'split_payment'     => [

            ],

        ], $message->getBillplzCollectionMessage()->toArray());
    }


    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\CollectionMessage
     */
    private function getCollectionMessage()
    {

        return new \Cyvelnet\LaravelBillplz\Messages\CollectionMessage(new \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage());

    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\OpenCollectionMessage
     */
    private function getOpenCollectionMessage()
    {

        return new \Cyvelnet\LaravelBillplz\Messages\OpenCollectionMessage(new \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage());

    }
}
