<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     * @param ?string $sortCreatedAt
     *
     * @return mixed
     */
    public function getAll(array $includes = [], ?string $sortCreatedAt = null);

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return mixed
     */
    public function getOne(string $id, array $includes = []);

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(string $id, array $attributes);
}
