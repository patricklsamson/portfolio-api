<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Services\MessageService;

class MessageController extends Controller
{
    /**
     * Model service
     *
     * @var MessageService
     */
    private $messageService;

    /**
     * Constructor
     *
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Get all models
     *
     * @param GetMessageRequest $request
     *
     * @return mixed
     */
    public function getAll(GetMessageRequest $request)
    {
        return $this->messageService->getAll($request->data($request));
    }

    /**
     * Get types
     *
     * @return mixed
     */
    public function getTypes()
    {
        return $this->messageService->getTypes();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param GetMessageRequest $request
     *
     * @return mixed
     */
    public function getOne(string $id, GetMessageRequest $request)
    {
        return $this->messageService->getOne($id, $request->data($request));
    }

    /**
     * Create model
     *
     * @param CreateMessageRequest $request
     *
     * @return mixed
     */
    public function create(CreateMessageRequest $request)
    {
        return $this->messageService->create($request->data($request));
    }

    /**
     * Update model
     *
     * @param string $id
     * @param UpdateMessageRequest $request
     *
     * @return mixed
     */
    public function updateType(string $id, UpdateMessageRequest $request)
    {
        return $this->messageService->updateType($id, $request->data($request));
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param DeleteMessageRequest $request
     *
     * @return mixed
     */
    public function delete(string $id, DeleteMessageRequest $request)
    {
        return $this->messageService->delete($id, $request->data($request));
    }
}
