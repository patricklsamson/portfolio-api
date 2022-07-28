<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Services\MessageService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

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
     *
     * @return void
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
     * @return ResourceCollection
     */
    public function getAll(GetMessageRequest $request): ResourceCollection
    {
        return $this->messageService->getAll($request);
    }

    /**
     * Get types
     *
     * @return Response
     */
    public function getTypes(): Response
    {
        return $this->messageService->getTypes();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param GetMessageRequest $request
     *
     * @return JsonResource
     */
    public function getOne(string $id, GetMessageRequest $request): JsonResource
    {
        return $this->messageService->getOne($id, $request);
    }

    /**
     * Create model
     *
     * @param CreateMessageRequest $request
     *
     * @return JsonResource
     */
    public function create(CreateMessageRequest $request): JsonResource
    {
        return $this->messageService->create($request);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param UpdateMessageRequest $request
     *
     * @return JsonResource
     */
    public function updateType(
        string $id,
        UpdateMessageRequest $request
    ): JsonResource {
        return $this->messageService->updateType($id, $request);
    }

    /**
     * Delete model/s
     *
     * @param string $id
     * @param DeleteMessageRequest $request
     *
     * @return Response
     */
    public function delete(string $id, DeleteMessageRequest $request): Response
    {
        return $this->messageService->delete($id, $request);
    }
}
