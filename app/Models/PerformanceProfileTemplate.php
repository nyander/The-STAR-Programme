<?php

namespace App\Models;

use App\Events\PerformanceProfileCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceProfileTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'default_value'
    ];

    protected $dispatchesEvents = [
        'created' => PerformanceProfileCreated::class,
    ];

    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(PerformanceTemplateQuestion::class, 'performance_template_id');
    }

    public function forms()
    {
        return $this->hasMany(CompletedPerformanceProfile::class);
    }
}
