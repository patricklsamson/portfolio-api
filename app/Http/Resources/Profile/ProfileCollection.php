<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\BaseCollection;

class ProfileCollection extends BaseCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = ProfileResource::class;
}
