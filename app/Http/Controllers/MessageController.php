<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMessageRequest;
use App\Traits\ResourceTrait;
use App\Services\MessageService;

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

    /**
     * Get all models
     *
     * @param GetMessageRequest $request
     *
     * @return mixed
     */
    public function getAll(GetMessageRequest $request)
    {
        return $this->resource($this->messageService->getAll($request->data($request)));
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
        return $this->resource($this->messageService->getOne($id, $request->data($request)));
    }
}
