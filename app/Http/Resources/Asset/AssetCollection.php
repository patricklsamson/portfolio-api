<?php

namespace App\Http\Resources\Asset;

use App\Http\Resources\BaseCollection;

class AssetCollection extends BaseCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = AssetResource::class;
}
