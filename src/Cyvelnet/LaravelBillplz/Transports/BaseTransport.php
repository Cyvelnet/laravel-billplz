<?php

namespace Cyvelnet\LaravelBillplz\Transports;

use Cyvelnet\LaravelBillplz\Exceptions\BillNotFoundException;
use Cyvelnet\LaravelBillplz\Exceptions\BillplzUnauthorizedException;
use Cyvelnet\LaravelBillplz\Exceptions\EndpointNotFoundException;
use Cyvelnet\LaravelBillplz\Exceptions\TemporarilyServiceUnavailableException;
use Cyvelnet\LaravelBillplz\Exceptions\UnacceptableRequestException;
use Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzMessage;
use Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage;
use Cyvelnet\LaravelBillplz\Response\BillResponse;
use Cyvelnet\LaravelBillplz\Response\CollectionResponse;
use GuzzleHttp\ClientInterface;

/**
 * Class BaseTransport.
 */
abstract class BaseTransport
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $http;

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $message
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    protected function sendCreateBillRequest(BillplzMessage $message)
    {
        $options = $this->buildBillBody($message);

        $url = $this->getRequestUrl(RequestTransport::CREATE_BILL_URL);

        return $this->sendBill('post', $url, $options);
    }

    /**
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse|mixed
     */
    protected function sendGetBillRequest($billId)
    {
        $url = $this->getRequestUrl(RequestTransport::GET_BILL_URL.$billId);

        return $this->sendBill('get', $url);
    }

    /**
     * @param $billId
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    protected function sendDeleteBillRequest($billId)
    {
        $url = $this->getRequestUrl(RequestTransport::DELETE_BILL_URL.$billId);

        $response = $this->sendBill('delete', $url);
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    protected function sendCreateCollectionRequest(BillplzCollectionMessage $collection)
    {
        $options = $this->buildCollectionBody($collection);

        $url = $this->getRequestUrl(RequestTransport::CREATE_COLLECTION_URL);

        return $this->sendCollection('post', $url, $options);
    }

    /**
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $collection
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    protected function sendCreateOpenCollectionRequest(BillplzOpenCollectionMessage $collection)
    {
        $options = $this->buildCollectionBody($collection);


        $url = $this->getRequestUrl(RequestTransport::CREATE_OPEN_COLLECTION_URL);

        return $this->sendCollection('post', $url, $options);
    }

    /**
     * send a bill related request to billplz gateway.
     *
     * @param $type
     * @param $url
     * @param array $options
     *
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\EndpointNotFoundException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\UnacceptableRequestException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\TemporarilyServiceUnavailableException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillplzUnauthorizedException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillNotFoundException
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    protected function sendBill($type, $url, $options = [])
    {
        $response = new BillResponse($this->sendBillplzServiceRequest($type, $url, $options));

        return $this->handleResponses($response, $url);
    }

    /**
     * send a collection related request to billplz gateway.
     *
     * @param $type
     * @param $url
     * @param $options
     *
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\EndpointNotFoundException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\UnacceptableRequestException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\TemporarilyServiceUnavailableException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillplzUnauthorizedException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillNotFoundException
     *
     * @return \Cyvelnet\LaravelBillplz\Response\CollectionResponse
     */
    protected function sendCollection($type, $url, $options)
    {
        $response = new CollectionResponse($this->sendBillplzServiceRequest($type, $url, $options));

        return $this->handleResponses($response, $url);
    }

    /**
     * send a services request to billplz gateway.
     *
     * @param $type
     * @param $url
     * @param array $options
     *
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillNotFoundException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillplzUnauthorizedException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\EndpointNotFoundException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\UnacceptableRequestException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\TemporarilyServiceUnavailableException
     *
     * @return \Cyvelnet\LaravelBillplz\Response\BillResponse
     */
    protected function sendBillplzServiceRequest($type, $url, $options = [])
    {
        // merge authentication header
        $options = array_merge_recursive($options, $this->getAuthOption());

        return $this->http->{$type}($url, $options);
    }

    /**
     * get authentication header option.
     *
     * @return array
     */
    protected function getAuthOption()
    {
        return ['auth' => [$this->apiKey, null]];
    }

    /**
     * build bill request body from message.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzMessage $message
     *
     * @return array
     */
    protected function buildBillBody(BillplzMessage $message)
    {
        $key = $this->getGuzzleRequestBodyKey();

        $options = [];

        $options[$key] = array_filter($message->toForm());

        return $options;
    }

    /**
     * build collection request body from message.
     *
     * @param \Cyvelnet\LaravelBillplz\Messages\BillplzCollectionMessage|\Cyvelnet\LaravelBillplz\Messages\BillplzOpenCollectionMessage $message
     *
     * @return array
     */
    protected function buildCollectionBody($message)
    {
        $key = $this->getGuzzleRequestBodyKey(true);

        $options = [];

        if ($message instanceof BillplzCollectionMessage) {
            $options[$key] = $this->formMultiparts(
                $message->toForm()
            );
        } else {
            if ($message instanceof BillplzOpenCollectionMessage) {
                $options[$key] = $this->formMultiparts(

                    $message->toForm()
                );
            }
        }

        return $options;
    }

    /**
     * retrieves corespondent api uri.
     *
     * @param $url
     *
     * @return string
     */
    protected function getRequestUrl($url)
    {
        $hostName = $this->sandboxMode ? RequestTransport::SANDBOX_HOST_NAME : RequestTransport::PRODUCTION_HOST_NAME;

        return "{$hostName}{$url}";
    }

    /**
     * handle response not found error.
     *
     * @param $response
     * @param $url
     *
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillNotFoundException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\EndpointNotFoundException
     */
    private function determineNotFoundException($response, $url)
    {
        if (array_key_exists('type', $response)) {
            throw new BillNotFoundException();
        }

        throw new EndpointNotFoundException($url);
    }

    /**
     * get guzzle request parameter key.
     *
     * @param bool $files
     *
     * @return string
     */
    private function getGuzzleRequestBodyKey($files = false)
    {
        if (version_compare(ClientInterface::VERSION, '6') === 1) {
            if ($files) {
                return 'multipart';
            }

            return 'form_params';
        }

        return 'body';
    }

    /**
     * form a multipart multidimensional array from array.
     *
     * @param array $options
     *
     * @return array
     */
    private function formMultiparts($options = [])
    {
        $multipartOptions = [];
        foreach ($options as $key => $option) {
            if (is_array($option)) {
                foreach ($option as $key2 => $subValue) {
                    $multipartOptions[] = [
                        'name'     => "{$key}[{$key2}]",
                        'contents' => $subValue,
                    ];
                }
            } else {
                $multipartOptions[] = [
                    'name'     => $key,
                    'contents' => $option,
                ];
            }
        }

        return $multipartOptions;
    }

    /**
     * handle potential services response errors from billplz gateway.
     *
     * @param $response
     * @param null $url
     *
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillNotFoundException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\BillplzUnauthorizedException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\TemporarilyServiceUnavailableException
     * @throws \Cyvelnet\LaravelBillplz\Exceptions\UnacceptableRequestException
     *
     * @return mixed
     */
    private function handleResponses($response, $url = null)
    {
        switch ($response->getHttpCode()) {

            case 401:
                throw new BillplzUnauthorizedException();
                break;
            case 404:
                $this->determineNotFoundException($response->getError(), $url);
                break;
            case 422:
                throw new UnacceptableRequestException($response->getError()->message);
                break;
            case 500:
                throw new TemporarilyServiceUnavailableException();
            default:

                return $response;
        }
    }
}
