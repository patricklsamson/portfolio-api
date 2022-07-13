<?php

namespace App\Services;

use App\Http\Requests\GetMessageRequest;
use App\Repositories\MessageRepository;

class MessageService
{
    /**
     * Model repository
     *
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * Constructor
     *
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Get all models
     *
     * @param array $request
     *
     * @return mixed
     */
    public function getAll(array $request)
    {
        return $this->messageRepository->getAll($request);
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
        return $this->messageRepository->getOne($id, $request);
    }
}
