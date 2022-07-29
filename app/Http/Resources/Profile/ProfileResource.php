<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\BaseResource;
use App\Models\Profile;

class ProfileResource extends BaseResource
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
            Profile::ATTRIBUTES, [
                $this->type,
                $this->description,
                $this->level,
                $this->starred,
                $this->start_date,
                $this->end_date,
                $this->metadata
            ]
        ));
    }
}
