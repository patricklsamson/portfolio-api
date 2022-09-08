<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Model
     *
     * @var Model
     */
    public $model;

    /**
     * Constructor
     *
     * @param Model $model
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models by ID
     *
     * @param array $ids
     *
     * @return ?Collection
     */
    public function getAllByIdIn(array $ids): ?Collection
    {
        return $this->model->whereIdIn($ids);
    }

    /**
     * Get one model
     *
     * @param string $id
     *
     * @return ?Model
     */
    public function getOne(string $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(string $id, array $attributes): Model
    {
        return tap(
            $this->model->where('id', $id)->first()
        )->update($attributes);
    }

    /**
     * Update or create model
     *
     * @param array $identifiersMap
     * @param array $attributes
     *
     * @return Model
     */
    public function updateOrCreate(
        array $identifiersMap,
        array $attributes
    ): Model {
        return $this->model->updateOrCreate($identifiersMap, $attributes);
    }

    /**
     * Delete model/s
     *
     * @param mixed $ids
     *
     * @return int
     */
    public function delete($ids): int
    {
        return $this->model->destroy($ids);
    }
}
