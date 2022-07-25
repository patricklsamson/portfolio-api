<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use App\Repositories\MessageRepository;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class MessageService
{
    use ResourceTrait;
    use ResponseTrait;

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
     *
     * @return void
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
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
        $data = $request->data($request);

        $messages = $this->messageRepository->getAll(
            Arr::get($data, 'filter.type'),
            Arr::get($data, 'include'),
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$messages->count(), NotFoundException::class);

        return $this->resource($messages);
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
        $message = $this->messageRepository->getOne($id, Arr::get(
            $request->data($request),
            'include'
        ));

        throw_if(!$message, NotFoundException::class);

        return $this->resource($message);
    }

    /**
     * Get types
     *
     * @return Response
     */
    public function getTypes(): Response
    {
        return response($this->groupContent(Message::TYPES, ['name']));
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
        return $this->resource($this->messageRepository->create(
            Arr::get($request->data($request), 'data.attributes')
        ));
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
        throw_if(
            !$message = $this->messageRepository->getOne($id),
            NotFoundException::class
        );

        $this->messageRepository->update($id, Arr::get(
            $request->data($request),
            'data.attributes'
        ));

        return $this->resource($message);
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param DeleteMessageRequest $request
     *
     * @return Response
     */
    public function delete(string $id, DeleteMessageRequest $request): Response
    {
        $ids = Arr::get($request->data($request), 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);

        throw_if(
            !$this->messageRepository->getAllByIdIn($ids),
            NotFoundException::class
        );

        $this->messageRepository->delete($ids);

        return response($this->content(['success' => true]));
    }
}
