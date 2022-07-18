<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     * @param ?string $sortCreatedAt
     *
     * @return mixed
     */
    public function getAll(array $includes = [], ?string $sortCreatedAt = null)
    {
        return User::with($includes)
            ->sortCreatedAt($sortCreatedAt)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return mixed
     */
    public function getOne(string $id, array $includes = [])
    {
        return User::with($includes)->find($id);
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes) {
        return User::create($attributes);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(string $id, array $attributes)
    {
        return User::where('id', $id)->update($attributes);
    }
}
