<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    /**
     * Enum attribute
     *
     * @var array
     */
    const LEVELS = [
        'beginner' => 1,
        'advanced' => 2,
        'competent' => 3,
        'proficient' => 4,
        'expert' => 5
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'level',
        'starred',
        'start_date',
        'end_date',
        'metadata',
        'user_id',
        'achievement_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['metadata' => 'array'];

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
     * Get parent model
     *
     * @return BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param string $level
     *
     * @return Builder
     */
    public function scopeWhereLevel(Builder $query, string $level): Builder
    {
        return $level ?? $query->where('level', $level);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param bool $starred
     *
     * @return Builder
     */
    public function scopeWhereStarred(Builder $query, bool $starred = true): Builder
    {
        return $query->where('starred', $starred);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param string $order
     *
     * @return Builder
     */
    public function scopeSortStartDate(Builder $query, string $order = 'DESC'): Builder
    {
        return $query->orderBy('start_date', $order);
    }
}
