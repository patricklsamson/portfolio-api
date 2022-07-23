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
    protected $model;

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
     * @return int
     */
    public function update(string $id, array $attributes): int
    {
        return $this->model->where('id', $id)->update($attributes);
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
