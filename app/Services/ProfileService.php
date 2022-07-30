<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Profile\DeleteProfileRequest;
use App\Http\Requests\Profile\GetProfileRequest;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProfileService
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
     * @param GetProfileRequest $request
     *
     * @return ResourceCollection
     */
    public function getAll(GetProfileRequest $request): ResourceCollection
    {
        $data = $request->data($request);

        $profiles = $this->repositoryService->profileRepository->getAll(
            Arr::get($data, 'filter.type'),
            Arr::get($data, 'filter.level'),
            Arr::get($data, 'filter.starred'),
            Arr::get($data, 'filter.role'),
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'cursor', false),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$profiles->count(), NotFoundException::class);

        return $this->resource($profiles);
    }

    /**
     * Delete model/s
     *
     * @param string $id
     * @param DeleteProfileRequest $request
     *
     * @return Response
     */
    public function delete(string $id, DeleteProfileRequest $request): Response
    {
        $ids = Arr::get($request->data($request), 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);

        throw_if(
            !$this->repositoryService->profileRepository->getAllByIdIn($ids),
            NotFoundException::class
        );

        $this->repositoryService->profileRepository->delete($ids);

        return response($this->content(['success' => true]));
    }
}
