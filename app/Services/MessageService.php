<?php

namespace App\Services;

use App\Repositories\MessageRepository;

class MessageService
{
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function getAll()
    {
        return $this->messageRepository->getAll();
    }

    public function getOne($id, $request)
    {
        return $this->messageRepository->getOne($id, $request);
    }
}
