<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get all models by ID
     *
     * @param array $ids
     *
     * @return ?Collection
     */
    public function getAllByIdIn(array $ids): ?Collection;

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
     * @return int
     */
    public function update(string $id, array $attributes): int;

    /**
     * Delete model/s
     *
     * @param mixed $ids
     *
     * @return int
     */
    public function delete($ids): int;
}