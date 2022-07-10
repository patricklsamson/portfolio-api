<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    public function getAll()
    {
        return Message::with('user')->get();
    }

    public function getOne($id, $request)
    {
        return Message::with('user')->find($id);
    }
}
