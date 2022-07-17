<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Message\MessageRepository;

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
        $message = $this->messageRepository->getOne($id, $request);

        throw_if(!$message, NotFoundException::class);

        return $message;
    }

    /**
     * Create model
     *
     * @param array $request
     *
     * @return mixed
     */
    public function create(array $request)
    {
        return $this->messageRepository->create($request);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $request
     *
     * @return mixed
     */
    public function updateType(string $id, array $request)
    {
        return $this->messageRepository->updateType($id, $request);
    }

    /**
     * Delete model
     *
     * @param string $id
     */
    public function delete(string $id, array $request)
    {
        return $this->messageRepository->delete($id, $request);
    }
}
