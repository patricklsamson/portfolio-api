<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\BaseCollection;

class MessageCollection extends BaseCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = MessageResource::class;
}
