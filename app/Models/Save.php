<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Save extends Model
{
    use HasUuids;
    protected $table = 'saves';
    protected $fillable = [
        'id',
        'user_id',
        'grid',
        'grid_size',
        'update_speed',
        'neighbor_thresholds',
        'selected_color'
    ];
    protected $casts = [
        'grid' => 'array',
        'neighbor_thresholds' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
