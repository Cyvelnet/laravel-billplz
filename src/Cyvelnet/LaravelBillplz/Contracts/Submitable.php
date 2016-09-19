<?php

namespace Cyvelnet\LaravelBillplz\Contracts;

interface Submitable
{
    /**
     * get guzzle friendly submittable array.
     *
     * @return array
     */
    public function toForm();
}
