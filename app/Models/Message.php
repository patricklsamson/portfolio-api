<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
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
     * @param mixed $type
     *
     * @return Builder
     */
    public function scopeWhereType(Builder $query, $type): Builder
    {
        if (!$type) {
            return $query;
        }

        return is_array($type) ? $query->whereIn('type', $type) : $query->where('type', $type);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param string $order
     *
     * @return Builder
     */
    public function scopeSortCreatedAt(Builder $query, string $order = 'DESC'): Builder
    {
        return $query->orderBy('created_at', $order);
    }
}
