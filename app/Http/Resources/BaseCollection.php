<?php

namespace App\Http\Resources;

use App\Traits\ArrayTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;

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
        if (!$request->get('include')) {
            return [];
        }

        $included = [];

        $this->collection->each(
            function($model) use ($request, &$included) {
                foreach ($this->strToArray($request->get('include')) as $include) {
                    if ($model->whenLoaded($include) instanceof MissingValue) {
                        continue;
                    }

                    $included[] = $this->resource($model->whenLoaded($include));
                }
            }
        );

        return $included ? ['included' => $included] : [];
    }
}
