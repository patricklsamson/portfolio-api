<?php

namespace App\Http\Resources;

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
        return $this->formatResponse([
            'sender' => $this->sender,
            'email' => $this->email,
            'body' => $this->body,
            'type' => $this->type
        ], $this->id);
    }
}
