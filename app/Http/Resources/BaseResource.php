<?php

namespace App\Http\Resources;

use App\Traits\ArrayTrait;
use App\Traits\ResourceTrait;
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
     * @param mixed $relationships
     * @param array $attributes
     * @param ?string $type
     *
     * @return array
     */
    public function formatResponse(
        Request $request,
        $id,
        $relationships,
        array $attributes,
        ?string $type = null
    ): array {
        $type = $this->type($type);
        $fields = Arr::get($request->get('fields'), $type);

        $response = [
            'type' => $type,
            'id' => $id,
            'attributes' => $fields ?
                collect($attributes)->only($this->strtoarray($fields)) : $attributes
        ];

        if ($relationships) {
            return array_merge($response, $relationships);
        }

        return $response;
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
        if (!$request->get('include')) {
            return [];
        }

        $includes = [];

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
                    $includes[] = $single;
                }

                continue;
            }

            $includes[] = $resource;
        }

        return empty(array_filter($includes)) ? [] : [
            'included' => array_values(array_filter($includes))
        ];
    }

    /**
     * Set relationships attribute
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function relationships($request)
    {
        if (!$request->get('include')) {
            return [];
        }

        $relationships = [];

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
                    $relationships[$include]['data'][] = array_merge(
                        $single->only('id'),
                        ['type' => Str::plural($include)]
                    );
                }

                continue;
            }

            $relationships[$include]['data'][] = array_merge(
                $resource->only('id'),
                ['type' => Str::plural($include)]
            );
        }

        return empty(array_filter($relationships)) ? null : ['relationships' => $relationships];
    }
}
