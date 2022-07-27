<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\BaseCollection;

class AddressCollection extends BaseCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = AddressResource::class;
}
