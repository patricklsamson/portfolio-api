<?php

namespace App\Traits;

trait ResourceTrait
{
    /**
     * Make resource/collection from model
     *
     * @param object $model
     *
     * @return object
     */
    public function resource(object $model): object
    {
        if (!$model || !$model->count()) {
            return null;
        }

        $resource = class_basename($model) == 'Collection' ?
            'App\Http\Resources\\' . class_basename($model[0]) . '\\' .
                class_basename($model[0]) . 'Collection' :
            'App\Http\Resources\\' . class_basename($model) . '\\' .
                class_basename($model) . 'Resource';

        return new $resource($model);
    }
}
