<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     *
     * @return mixed
     */
    public function getAll(array $includes = []);

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
     * @param int $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * Delete model
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id);
}
