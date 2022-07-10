<?php

namespace App\Http\Resources;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;

class BaseCollection extends ResourceCollection
{
    use ResourceTrait;

    public function with($request): array
    {
        $include = $request->get('include');
        $included = [];

        $this->collection->each(
            function($model) use ($include, &$included) {
                if ($model->whenLoaded($include) instanceof MissingValue) {
                    return;
                }

                $included[] = $this->resource($model->whenLoaded($include));
            }
        );

        return $include && $included ? ['included' => $included] : [];
    }
}
