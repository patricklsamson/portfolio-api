<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\BaseResource;
use App\Models\Address;

class AddressResource extends BaseResource
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
        return $this->formatResponse(
            $request,
            $this->id,
            array_combine(Address::ATTRIBUTES, [
                $this->line_1,
                $this->line_2,
                $this->district,
                $this->city,
                $this->state,
                $this->country,
                $this->zip_code
            ])
        );
    }
}
