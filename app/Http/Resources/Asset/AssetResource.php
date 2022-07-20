<?php

namespace App\Http\Resources\Asset;

use App\Http\Resources\BaseResource;
use App\Models\Asset;

class AssetResource extends BaseResource
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
            array_combine(Asset::ATTRIBUTES, [
                $this->name,
                $this->slug,
                $this->type,
                $this->metadata
            ])
        );
    }
}
