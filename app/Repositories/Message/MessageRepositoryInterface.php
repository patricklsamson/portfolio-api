<?php

namespace App\Repositories\Message;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

interface MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     * @param ?array $filterTypes
     * @param ?array $ids
     *
     * @return Collection
     */
    public function getAll(
        array $includes = [],
        ?array $filterTypes = null,
        ?array $ids = null
    ): Collection;

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return Message
     */
    public function getOne(string $id, array $includes = []): Message;

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return Message
     */
    public function create(array $attributes): Message;

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return Message
     */
    public function update(string $id, array $attributes): Message;

    /**
     * Delete model
     *
     * @param array $ids
     *
     * @return int
     */
    public function delete(array $ids): int;
}
