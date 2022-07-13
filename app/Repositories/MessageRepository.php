<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $request
     *
     * @return mixed
     */
    public function getAll(array $request)
    {
        return Message::with($request['include'])
            ->whereType($request['filter']['type'])
            ->sortCreatedAt($request['sort']['created_at'])
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $request
     *
     * @return mixed
     */
    public function getOne(string $id, array $request)
    {
        return Message::with($request['include'])->find($id);
    }
}
