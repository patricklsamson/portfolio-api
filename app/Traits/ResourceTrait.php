<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ResourceTrait
{
    /**
     * Make resource/collection from model
     *
     * @param ?object $model
     *
     * @return ?object
     */
    public function resource(?object $model): ?object
    {
        if (!$model || !$model->count()) {
            return null;
        }

        $isCollection = class_basename($model) == 'Collection' ||
            class_basename($model) == 'LengthAwarePaginator' ||
            class_basename($model) == 'CursorPaginator';

        $resource = $isCollection ?
            'App\Http\Resources\\' . class_basename($model[0]) . '\\' .
                class_basename($model[0]) . 'Collection' :
            'App\Http\Resources\\' . class_basename($model) . '\\' .
                class_basename($model) . 'Resource';

        return new $resource($model);
    }
}
