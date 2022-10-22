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
     * Get categories
     *
     * @return Response
     */
    public function getCategories(): Response
    {
        return $this->messageService->getCategories();
    }

    /**
     * Get one model
     *
     * @param string $id
     *
     * @return JsonResource
     */
    public function getOne(string $id): JsonResource
    {
        return $this->messageService->getOne($id);
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
    public function update(
        string $id,
        UpdateMessageRequest $request
    ): JsonResource {
        return $this->messageService->update($id, $request);
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
