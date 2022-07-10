<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender', 'email', 'body', 'type', 'user_id'];

    /**
     * Get parent model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param string $type
     *
     * @return Builder
     */
    public function scopeWhereType(Builder $query, string $type): Builder
    {
        return $type ?? $query->where('type', $type);
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
