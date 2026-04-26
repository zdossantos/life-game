<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Save extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'saves';

    protected $fillable = [
        'id',
        'user_id',
        'grid',
        'grid_size',
        'update_speed',
        'neighbor_thresholds',
        'selected_color',
        'cycle_count',
    ];

    protected $casts = [
        'grid' => 'array',
        'neighbor_thresholds' => 'array',
    ];

    public function getSettingsAttribute(): array
    {
        return [
            'gridSize' => $this->grid_size,
            'updateSpeed' => $this->update_speed,
            'selectedColor' => $this->selected_color,
            'neighborThresholds' => $this->neighbor_thresholds,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
