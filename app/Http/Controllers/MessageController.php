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

    public function getAll(): ResourceCollection
    {
        return $this->resource($this->messageService->getAll());
    }

    public function getOne(string $id, GetMessageRequest $request): JsonResource
    {
        // dd($request->data($request));
        return $this->resource($this->messageService->getOne($id, $request->data($request)));
    }
}
