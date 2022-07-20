<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends BaseModel
{
    use HasFactory;

    /**
     * Enum attribute
     *
     * @var array
     */
    const TYPES = ['inbox', 'archives', 'spam'];

    /**
     * Resource attributes
     *
     * @var array
     */
    const ATTRIBUTES = ['sender', 'email', 'body', 'type'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender', 'email', 'body', 'type', 'user_id'];

    /**
     * Get parent model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
     * @param ?array $type
     *
     * @return Builder
     */
    public function scopeFilterTypes(
        Builder $query,
        ?array $type = null
    ): Builder {
        return $type ? $query->whereIn('type', $type) : $query;
    }
}
