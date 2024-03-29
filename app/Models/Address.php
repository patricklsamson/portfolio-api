<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends BaseModel
{
    use HasFactory;

    /**
     * Resource attributes
     *
     * @var array
     */
    const ATTRIBUTES = [
        'line_1',
        'line_2',
        'district',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'line_1',
        'line_2',
        'district',
        'city',
        'state',
        'country',
        'zip_code',
        'parentable_id',
        'parentable_type'
    ];

    /**
     * Get parentable model
     *
     * @return MorphTo
     */
    public function parentable(): MorphTo
    {
        return $this->morphTo();
    }
}
