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
    const CATEGORIES = ['inbox', 'archives', 'spam'];

    /**
     * Resource attributes
     *
     * @var array
     */
    const ATTRIBUTES = ['sender', 'email', 'body', 'category'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender', 'email', 'body', 'category', 'user_id'];

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
     *
     * @return Builder
     */
    public function scopeByOwner(Builder $query): Builder
    {
        return $query->where('user_id', auth()->user()->id);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $categories
     *
     * @return Builder
     */
    public function scopeFilterCategory(
        Builder $query,
        ?array $categories = null
    ): Builder {
        return $categories ? $query->whereIn('category', $categories) : $query;
    }
}
