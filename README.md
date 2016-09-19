# laravel-billplz

Laravel-billplz is a simple service providers and generator to connect your laravel powered app to Billplz api v3.

[![StyleCI](https://styleci.io/repos/68587947/shield?branch=master)](https://styleci.io/repos/68587947)

### Install

Require this package with composer using the following command:

``` bash
composer require cyvelnet/laravel-billplz
```

After updating and installed, add the service provider to the  `providers` array in `config/app.php` file

```php
Cyvelnet\LaravelBillplz\LaravelBillplzServiceProvider::class
```
And finally add the facade to the `facades` array section in `config/app.php`

```php
Cyvelnet\LaravelBillplz\Facades\Billplz::class
```

### How to use

#### Bills api

##### Create a bill
###### To create a billplz bill

```php 
\Billplz::issue(function (Cyvelnet\LaravelBillplz\Messages\BillMessage $bill)
    {
        // bill with a amount RM50
        $bill->to('name', 'email', 'mobile')
             ->amount(50) // will multiply with 100 automatically, so a RM500 bill, you just pass 500 instead of 50000
             ->callbackUrl('http://foorbar.com/foo/bar/webhook/');
    });
```
An UnacceptableRequestException will be throw for any call with any missing parameter.

Alternatively, you may generate reusable bill with artisan command `php artisan make:bill MonthlyManagementBill`

```php

\Billplz::send(new MonthlyManagementBill())
        ->to('foobar')
        ->viaEmail('foo@bar.com') // you may use viaSms('mobile no') or viaEmailAndSms('email', 'mobile no')

```

##### To delete an existing bill
```php

$request = \Billplz::delete('bill_id');

if($request->isSuccess())
{
    // perform after deletion operation 
}
```

##### To retrieves a bill

```php

$bill = \Billplz::get('bill_id')->toArray();

```

A BillNotFoundException will be throw for any missing bill.


#### Collections api

##### To create a collection

```php
    $request = \Billplz::collection('collection title');
    
    if($request->isSuccess())
    {
        $collection = $request->toArray() // you can call getRawBillplzResponse(false) to get response in POPO
    }
```
to customize your collection more, pass in an anonymous function as the second parameter

```php

    $request = \Billplz::collection('collection title', function (\Cyvelnet\LaravelBillplz\Messages\CollectionMessage $collection) {
    
        // split a payment by RM50
        $collection->logo(storage_path('/billplz/my-logo.jpg'))
                   ->splitPaymentByFixed('foo@bar.com', 50)     // will convert into 5000 cents automatically
    });

```

##### To create an open collection with fixed amount

```php
    // create a open collection with a fixed amount RM500
    $request = \Billplz::openCollection('collection title', 'collection description', 500);
    
    if($request->isSuccess())
    {
        $collection = $request->toArray() // you can call getRawBillplzResponse(false) to get response in POPO
    }
```

##### To create an open collection with any amount and any quantity pass a closure as third parameter

```php
    // create a open collection with a fixed amount RM500
    $request = \Billplz::openCollection('collection title', 'collection description', function (\Cyvelnet\LaravelBillplz\Messages\OpenCollectionMessage $collection) {
    
        $collection->anyAmountAndQty();
        //         ->splitPaymentByVariable('foo@bar.com', 50);  // split payment by 50%
        //         ->tax(6)   // 6% tax
        //         ->photo(storage_path('/billplz/my-photo.jpg'))
        //         ->reference1('your references')
    
    });
    
    if($request->isSuccess())
    {
        $collection = $request->toArray() // you can call getRawBillplzResponse(false) to get response in POPO
    }
```






