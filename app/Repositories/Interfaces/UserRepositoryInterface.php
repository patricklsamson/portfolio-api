<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $includes
     *
     * @return ?Collection
     */
    public function getAll(?array $includes = null): ?Collection;

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?User
     */
    public function getOne(string $id, ?array $includes = null): ?User;
}
