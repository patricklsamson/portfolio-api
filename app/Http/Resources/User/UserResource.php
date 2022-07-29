<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Models\User;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return $this->formatResponse($request, $this->id, array_combine(
            User::ATTRIBUTES, [
                $this->name,
                $this->email,
                $this->username,
                $this->metadata
            ]
        ));
    }
}