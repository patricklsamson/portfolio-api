<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Http\Requests\Message\GetMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
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
     * Repository service
     *
     * @var RepositoryService
     */
    private $repositoryService;

    /**
     * Constructor
     *
     * @param RepositoryService $repositoryService
     *
     * @return void
     */
    public function __construct(RepositoryService $repositoryService)
    {
        $this->repositoryService = $repositoryService;
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

        $messages = $this->repositoryService->messageRepository->getAll(
            Arr::get($data, 'filter.category'),
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'cursor', false),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$messages->count(), NotFoundException::class);

        return $this->resource($messages);
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
        $message = $this->repositoryService->messageRepository->getOne($id);

        throw_if(!$message, NotFoundException::class);

        return $this->resource($message);
    }

    /**
     * Get categories
     *
     * @return Response
     */
    public function getCategories(): Response
    {
        return response($this->groupContent(Message::CATEGORIES, ['name']));
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
        return $this->resource(
            $this->repositoryService->messageRepository->create(Arr::get(
                $request->data($request),
                'data.attributes'
            ))
        );
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
        throw_if(
            !$this->repositoryService->messageRepository->getOne(
                $id
            ),
            NotFoundException::class
        );

        return $this->resource(
            $this->repositoryService->messageRepository->update($id, Arr::get(
                $request->data($request),
                'data.attributes'
            ))
        );
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
        $ids = Arr::get($request->data($request), 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);

        throw_if(
            !$this->repositoryService->messageRepository->getAllByIdIn($ids),
            NotFoundException::class
        );


        $this->repositoryService->messageRepository->delete($ids);

        return response($this->content([
            'success' => true,
            'purged' => $this->purgedIdsMap($ids)
        ]));
    }
}
