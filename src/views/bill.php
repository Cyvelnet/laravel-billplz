<?= "<?php

namespace {$namespace};" ?>

<?= '
use \\Cyvelnet\\LaravelBillplz\\BillplzPaymentBill;
' ?>

<?= "class {$class_name} extends BillplzPaymentBill
{" ?>

    /**
     * define bill properties.
     *
     * @return array
     */
    public function bill()
    {

        // for more information about these paramters, visit https://www.billplz.com/api#create-a-bill17
        return [

             'amount'               => 0,            //   50 for RM50, will multiply with 100 automatically
             'description'          => ''            //   (Max of 200 characters), will be trim to 200 character automatically.

            /*
            |--------------------------------------------------------------------------
            | Optional parameters
            |--------------------------------------------------------------------------
            */

            // 'collection_id'      => '',
            // 'callback_url'       => 'foo@bar.com/webhook/callback',
            // 'due_at'             => '2016-09-18',
            // 'redirect_url'       => ''
            // 'deliver'            => false
            // 'reference_label_1'  => 'Reference 1'        (Max of 120 characters), will be trim to 120 character automatically.
            // 'reference_1'        => ''                   (Max of 20 characters), will be trim to 20 character automatically.
            // 'reference_label_2'  => 'Reference 2'        (Max of 120 characters), will be trim to 120 character automatically.
            // 'reference_2'        => 'Reference 2'        (Max of 20 characters), will be trim to 20 character automatically.

        ];
    }

}
