<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     * @param array $sorts
     *
     * @return Collection
     */
    public function getAll(array $includes = [], array $sorts = []): Collection
    {
        return User::with($includes)
            ->sort($sorts)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return User
     */
    public function getOne(string $id, array $includes = []): User
    {
        return User::with($includes)->find($id);
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return User
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * Update model
     *
     * @param int $id
     * @param array $attributes
     *
     * @return User
     */
    public function update(int $id, array $attributes): User
    {
        return User::where('id', $id)->update($attributes);
    }

    /**
     * Delete model/s
     *
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id): int
    {
        return User::destroy($id);
    }
}
