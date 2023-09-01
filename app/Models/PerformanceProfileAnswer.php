<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceProfileAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'performance_profile_id',
        'question_id',
        'question_text',
        'question_type',
        'answers',
    ];

    public function performanceProfileTemplate()
    {
        return $this->belongsTo(PerformanceProfile::class);
    }

    public function question()
    {
        return $this->belongsTo(PerformanceTemplateQuestion::class, 'question_id');
    }
}
