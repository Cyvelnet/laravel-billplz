<?php

/**
 * Class BillTest
 */
class BillTest extends Orchestra\Testbench\TestCase
{
    /**
     * @test
     */
    public function it_should_automatically_multiply_by_one_hundred()
    {
        $message = $this->getBillMessage();

        $message->amount(50);

        $this->assertEquals(50 * 100, $message->getBillplzMessage()->getAmount());
    }

    /**
     * @test
     */
    public function it_should_set_deliver_to_true_when_mobile_number_is_supplied()
    {
        $message = $this->getBillMessage();

        $message->mobile('60123456789');

        $this->assertEquals('60123456789', $message->getBillplzMessage()->getMobile());
        $this->assertEquals(true, $message->getBillplzMessage()->isDeliver());
    }

    /**
     * @test
     */
    public function it_should_set_name_email_and_mobile()
    {
        $message = $this->getBillMessage();

        $message->to('foobar', 'foobar@foo.com', '60123456789');

        $this->assertEquals('foobar', $message->getBillplzMessage()->getName());
        $this->assertEquals('foobar@foo.com', $message->getBillplzMessage()->getEmail());
        $this->assertEquals('60123456789', $message->getBillplzMessage()->getMobile());
        $this->assertEquals(true, $message->getBillplzMessage()->isDeliver());
    }


    /**
     * @test
     */
    public function it_should_able_to_set_values_correctly()
    {
        $message = $this->getBillMessage();

        $message->amount(10)
            ->callbackUrl('http:\\foorbar.com\callback')
            ->collectionId('collect_id')
            ->description('this is description')
            ->dueAt('2016-09-20')
            ->reference1Label('foo label')
            ->reference1('foo reference')
            ->reference2Label('bar label')
            ->reference2('bar reference')
            ->redirectUrl('http:\\foobar.com\\redirect')
            ->to('foobar', 'foobar@bar.com', 60123456789);

        $this->assertSame([
            'collection_id'     => 'collect_id',
            'email'             => 'foobar@bar.com',
            'mobile'            => 60123456789,
            'name'              => 'foobar',
            'amount'            => 1000,
            'callback_url'      => 'http:\\foorbar.com\\callback',
            'description'       => 'this is description',
            'due_at'            => '2016-09-20',
            'redirect_url'      => 'http:\\foobar.com\\redirect',
            'deliver'           => 'true',
            'reference_1_label' => 'foo label',
            'reference_1'       => 'foo reference',
            'reference_2_label' => 'bar label',
            'reference_2'       => 'bar reference',

        ], $message->getBillplzMessage()->toArray());
    }

    /**
     * @return \Cyvelnet\LaravelBillplz\Messages\BillMessage
     */
    private function getBillMessage()
    {

        return new \Cyvelnet\LaravelBillplz\Messages\BillMessage(new \Cyvelnet\LaravelBillplz\Messages\BillplzMessage);

    }
}
