<?php

namespace App\Repositories\Message;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository implements MessageRepositoryInterface
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
    ): Collection {
        return Message::with($includes)
            ->whereIdIn($ids)
            ->filterTypes($filterTypes)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return Message
     */
    public function getOne(string $id, array $includes = []): Message
    {
        return Message::with($includes)->find($id);
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return Message
     */
    public function create(array $attributes): Message
    {
        return Message::create($attributes);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return Message
     */
    public function update(string $id, array $attributes): Message
    {
        return Message::where('id', $id)->update($attributes);
    }

    /**
     * Delete model/s
     *
     * @param array $ids
     *
     * @return int
     */
    public function delete(array $ids): int
    {
        return Message::destroy($ids);
    }
}
