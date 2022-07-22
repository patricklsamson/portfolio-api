<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Message;
use App\Repositories\Message\MessageRepository;
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
     * @param array $data
     *
     * @return ResourceCollection
     */
    public function getAll(array $data): ResourceCollection
    {
        $messages = $this->messageRepository->getAll(
            Arr::get($data, 'include'),
            Arr::get($data, 'filter.type')
        );

        throw_if(!$messages->count(), NotFoundException::class);

        return $this->resource($messages);
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $data
     *
     * @return JsonResource
     */
    public function getOne(string $id, array $data): JsonResource
    {
        $message = $this->messageRepository
            ->getOne($id, Arr::get($data, 'include'));

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
     * @param array $data
     *
     * @return JsonResource
     */
    public function create(array $data): JsonResource
    {
        return $this->resource(
            $this->messageRepository->create(Arr::get($data, 'data.attributes'))
        );
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $data
     *
     * @return JsonResource
     */
    public function updateType(string $id, array $data): JsonResource
    {
        $message = $this->messageRepository->getOne($id);
        throw_if(!$message, NotFoundException::class);

        $this->messageRepository
            ->update($id, Arr::get($data, 'data.attributes'));

        return $this->resource($this->messageRepository->getOne($id));
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param array $data
     *
     * @return Response
     */
    public function delete(string $id, array $data): Response
    {
        $ids = Arr::get($data, 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);
        $messages = $this->messageRepository->getAll([], null, $ids);
        throw_if(!$messages->count(), NotFoundException::class);
        $this->messageRepository->delete($ids);

        return response($this->content(['success' => true]));
    }
}
