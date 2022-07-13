<?php

namespace App\Traits;

trait ResourceTrait
{
    /**
     * Make resource/collection from model
     */
    public function resource(object $model): object
    {
        $resource = 'App\Http\Resources\\' . class_basename($model) . 'Resource';

        if (class_basename($model) == 'Collection') {
            $resource = 'App\Http\Resources\\' . class_basename($model[0]) . 'Collection';
        }

        return new $resource($model);
    }
}
