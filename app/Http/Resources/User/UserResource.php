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
                $this->first_name,
                $this->middle_name,
                $this->last_name,
                $this->email,
                $this->username,
                $this->metadata
            ]
        ));
    }
}