<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get all models by ID
     *
     * @param array $ids
     *
     * @return ?Builder
     */
    public function getAllByIdIn(array $ids): ?Builder;

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(string $id, array $attributes): Model;

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
    ): Model;

    /**
     * Delete model/s
     *
     * @param mixed $ids
     *
     * @return int
     */
    public function delete($ids): int;
}
