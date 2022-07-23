<?php

namespace App\Repositories\Interfaces;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

interface MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $includes
     * @param ?array $filterTypes
     *
     * @return ?Collection
     */
    public function getAll(
        ?array $includes = null,
        ?array $filterTypes = null
    ): ?Collection;

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?Message
     */
    public function getOne(string $id, ?array $includes = null): ?Message;
}
