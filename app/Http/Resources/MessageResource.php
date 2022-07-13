<?php

namespace App\Http\Resources;

use App\Models\Message;

class MessageResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->formatResponse(
            $request,
            $this->id,
            $this->relationships($request),
            array_combine(Message::ATTRIBUTES, [
                $this->sender,
                $this->email,
                $this->body,
                $this->type
            ])
        );
    }
}
