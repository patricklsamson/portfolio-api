<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMessageRequest;
use App\Traits\ResourceTrait;
use App\Services\MessageService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageController extends Controller
{
    use ResourceTrait;

    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function getAll(): ResourceCollection
    {
        return $this->resource($this->messageService->getAll());
    }

    public function getOne(string $id, GetMessageRequest $request): JsonResource
    {
        return $this->resource($this->messageService->getOne($id, $request->data()));
    }
}
