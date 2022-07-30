<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $ids
     *
     * @return Builder
     */
    public function scopeWhereIdIn(Builder $query, ?array $ids = null): Builder
    {
        return $ids ? $query->whereIn('id', $ids) : $query;
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param bool $isCursor
     * @param ?string $pageCursor
     *
     * @return mixed
     */
    public function scopePage(
        Builder $query,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        bool $isCursor = false,
        ?string $pageCursor = null
    ) {
        if ($query->get()->count() > 10) {
            $pageSize = 10;
        }

        return $pageSize ? (
            $isCursor ? $query->cursorPaginate(
                $pageSize,
                ['*'],
                'page[cursor]',
                $pageCursor
            ) : $query->paginate($pageSize, ['*'], 'page[number]', $pageNumber)
        ) : $query->get();
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $sorts
     *
     * @return Builder
     */
    public function scopeSort(Builder $query, ?array $sorts = null): Builder
    {
        return $query->when($sorts, function ($query) use ($sorts) {
            foreach (array_chunk($sorts, 2) as $sort) {
                $query->orderBy(...$sort);
            }
        });
    }
}
