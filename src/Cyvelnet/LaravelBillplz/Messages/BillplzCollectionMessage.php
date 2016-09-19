<?php

namespace Cyvelnet\LaravelBillplz\Messages;

/**
 * Class BillMessage.
 */
class BillplzCollectionMessage extends BillplzCollectionCommonMessage
{
    /**
     * @var string
     */
    protected $logo;

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * get guzzle friendly submittable array.
     *
     * @return array
     */
    public function toForm()
    {
        $params = $this->toArray();

        if (array_key_exists('logo', $params) and $params['logo']) {
            $params['logo'] = @fopen($params['logo'], 'r');
        }

        return array_filter($params, function ($param) {
            return $param !== '' or !is_null($param);
        });
    }
}
