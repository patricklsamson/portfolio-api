<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Message;
use App\Repositories\Message\MessageRepository;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class MessageService
{
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
     * @return mixed
     */
    public function getAll(array $data)
    {
        $messages = $this->messageRepository->getAll(
            Arr::get($data, 'include'),
            Arr::get($data, 'filter.type'),
            Arr::get($data, 'sort.created_at')
        );

        throw_if(!$messages->count(), NotFoundException::class);

        return $messages;
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $data
     *
     * @return mixed
     */
    public function getOne(string $id, array $data)
    {
        $message = $this->messageRepository
            ->getOne($id, Arr::get($data, 'include'));

        throw_if(!$message, NotFoundException::class);

        return $message;
    }

    /**
     * Get types
     *
     * @return mixed
     */
    public function getTypes()
    {
        return response(
            $this->buildGroupContent(Message::TYPES, ['name'])
        );
    }

    /**
     * Create model
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->messageRepository
            ->create(Arr::get($data, 'data.attributes'));
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $data
     *
     * @return mixed
     */
    public function updateType(string $id, array $data)
    {
        $message = $this->messageRepository->getOne($id);
        throw_if(!$message, NotFoundException::class);

        $this->messageRepository
            ->update($id, Arr::get($data, 'data.attributes'));

        return $this->messageRepository->getOne($id);
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param array $data
     *
     * @return mixed
     */
    public function delete(string $id, array $data)
    {
        $ids = Arr::get($data, 'ids');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);
        $messages = $this->messageRepository->getAll([], null, null, $ids);
        throw_if(!$messages->count(), NotFoundException::class);
        $this->messageRepository->delete($ids);

        return response($this->buildContent(['success' => true]));
    }
}
