<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     *
     * @return Collection
     */
    public function getAll(array $includes = []): Collection;

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return User
     */
    public function getOne(string $id, array $includes = []): User;

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return User
     */
    public function create(array $attributes): User;

    /**
     * Update model
     *
     * @param int $id
     * @param array $attributes
     *
     * @return User
     */
    public function update(int $id, array $attributes): User;

    /**
     * Delete model
     *
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id): int;
}
