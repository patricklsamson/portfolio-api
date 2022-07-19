<?php

namespace App\Http\Resources;

use App\Traits\ArrayTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Arr;

class BaseCollection extends ResourceCollection
{
    use ArrayTrait;
    use ResourceTrait;

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

        $this->collection->each(
            function($model) use ($request, &$includes) {
                foreach (
                    $this->strToArray($request->get('include')) as $include
                ) {
                    if ($model->whenLoaded($include) instanceof MissingValue) {
                        continue;
                    }

                    $resource = $this->resource($model->whenLoaded($include));

                    if (!$resource) {
                        continue;
                    }

                    if ($resource instanceof ResourceCollection) {
                        foreach ($resource as $single) {
                            if (
                                !$single || array_key_exists(
                                    $single->only('id')['id'],
                                    $includes
                                )
                            ) {
                                continue;
                            }

                            Arr::set(
                                $includes,
                                'included.' . $single->only('id')['id'],
                                $single
                            );
                        }

                        continue;
                    }

                    $includes['included'][] = $resource;
                }
            }
        );

        return empty($includes) ? $includes : Arr::set(
            $includes,
            'included',
            array_values(Arr::get($includes, 'included', []))
        );
    }
}
