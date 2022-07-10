<?php

namespace App\Http\Resources;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Str;

class BaseResource extends JsonResource
{
    use ResourceTrait;

    public function formatResponse(array $attributes, $id, ?string $type = null): array
    {
        return [
            'type' => $this->type($type),
            'id' => $id,
            'attributes' => $attributes
        ];
    }

    public function type(?string $type = null): string
    {
        return $type ? $type : Str::plural(strtolower(
            str_replace('Resource', '', class_basename($this->resource))
        ));
    }

    public function with($request): array
    {
        $include = $request->get('include');
        $included = $this->whenLoaded($include) instanceof MissingValue ?
            null : [$this->resource($this->whenLoaded($include))];

        return $include && $included ? ['included' => $included] : [];
    }
}
