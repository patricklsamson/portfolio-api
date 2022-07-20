<?php

namespace App\Http\Resources;

use App\Traits\ArrayTrait;
use App\Traits\ResourceTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BaseResource extends JsonResource
{
    use ArrayTrait;
    use ResourceTrait;

    /**
     * Format response for resource
     *
     * @param Request $request
     * @param mixed $id
     * @param array $attributes
     * @param ?string $type
     *
     * @return array
     */
    public function formatResponse(
        Request $request,
        $id,
        array $attributes,
        ?string $type = null
    ): array {
        $type = $this->type($type);
        $fields = Arr::get($request->get('fields'), $type);

        return array_filter(array_merge([
            'type' => $type,
            'id' => $id,
            'attributes' => $fields ?
                collect($attributes)->only($this->strtoarray($fields)) :
                $attributes
        ], $this->relationships($request)));
    }

    /**
     * Retrieve data type
     *
     * @param ?string $type
     *
     * @return string
     */
    public function type(?string $type = null): string
    {
        return $type ? $type : Str::plural(strtolower(
            str_replace('Resource', '', class_basename($this->resource))
        ));
    }

    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function with($request): array
    {
        $includes = [];

        if (!$request->get('include')) {
            return $includes;
        }

        foreach ($this->strToArray($request->get('include')) as $include) {
            if ($this->whenLoaded($include) instanceof MissingValue) {
                continue;
            }

            $resource = $this->resource($this->whenLoaded($include));

            if (!$resource) {
                continue;
            }

            if ($resource instanceof ResourceCollection) {
                foreach ($resource as $single) {
                    if (!$single) {
                        continue;
                    }

                    $includes['included'][] = $single;
                }

                continue;
            }

            $includes['included'][] = $resource;
        }

        return $includes;
    }

    /**
     * Set relationships attribute
     *
     * @param Request $request
     *
     * @return array
     */
    public function relationships($request): array
    {
        $relationships = [];

        if (!$request->get('include')) {
            return $relationships;
        }

        foreach ($this->strToArray($request->get('include')) as $include) {
            if (!$this->$include) {
                continue;
            }

            if ($this->$include instanceof Collection) {
                foreach ($this->$include as $single) {
                    if (!$single) {
                        continue;
                    }

                    $relationships['relationships'][$include]['data'][] = [
                        'id' => $single->id,
                        'type' => Str::plural($include)
                    ];
                }

                continue;
            }

            $relationships['relationships'][$include]['data'][] = [
                'id' => $this->$include->id,
                'type' => Str::plural($include)
            ];
        }

        return $relationships;
    }
}
