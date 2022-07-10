<?php

namespace App\Http\Resources;

class MessageCollection extends BaseCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = MessageResource::class;
}
