<?php

namespace App\Http\Resources;

use App\Models\User;

class UserResource extends BaseResource
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
            array_combine(User::ATTRIBUTES, [
                $this->name,
                $this->email,
                $this->username,
                $this->objective,
                $this->about,
                $this->metadata
            ])
        );
    }
}