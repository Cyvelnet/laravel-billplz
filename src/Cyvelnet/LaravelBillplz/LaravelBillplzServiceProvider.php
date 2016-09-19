<?php

namespace Cyvelnet\LaravelBillplz;

use Cyvelnet\LaravelBillplz\Consoles\BillGenerationConsole;
use Cyvelnet\LaravelBillplz\Transports\RequestTransport;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class LaravelBillplzServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $source_config = __DIR__.'/../../config/billplz.php';
        $this->publishes([$source_config => 'config/billplz.php'], 'config');
        $this->loadViewsFrom(__DIR__.'/../../views', 'billplz');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('billplz', function ($app) {
            $enableSandbox = $app['config']->get('billplz.sandbox_mode', false);

            $key = $this->getConfigKey($enableSandbox);

            $apiKey = $this->getApiKey($key);
            $collectionId = $this->getCollectionId($key);
            $callbackUrl = $this->app['config']->get('billplz.callback_url');
            $references = $this->app['config']->get('billplz.references');

            $logo = $this->app['config']->get('billplz.logo');
            $photo = $this->app['config']->get('billplz.photo');

            $http = $this->createHttpClient();

            dd($logo, $photo);

            $billplzPayment = new BillplzPayment(new RequestTransport($http, $apiKey, $enableSandbox));

            $billplzPayment->defaultBills($collectionId, $callbackUrl, $references);
            $billplzPayment->defaultCollections($logo, $photo);


            return $billplzPayment;
        });

        $this->commands(BillGenerationConsole::class);
    }

    private function getConfigKey($sandbox)
    {
        return $sandbox ? 'sandbox' : 'production';
    }

    private function getApiKey($key)
    {
        return $this->app['config']->get("billplz.api_key.{$key}");
    }

    private function getCollectionId($key)
    {
        return $this->app['config']->get("billplz.collection_id.{$key}");
    }

    /**
     * create a http client.
     *
     * @return \GuzzleHttp\Client
     */
    private function createHttpClient()
    {
        if (version_compare(ClientInterface::VERSION, '6') === 1) {
            return new Client([
                'exceptions' => false,
                'headers'    => [
                    'Accept' => 'application/json',
                ],
                //'debug'      => true,
            ]);
        } else {
            $client = new Client();
            $client->setDefaultOption('exceptions', false);

            return $client;
        }
    }
}
