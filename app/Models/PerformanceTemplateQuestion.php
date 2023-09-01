<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceTemplateQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'performance_template_id',
        'title',
        'text',
        'type',
        'options',
        'performance_categories',
        'required',
        'order',
    ];

    public function performanceTemplate()
    {
        return $this->belongsTo(PerformanceProfileTemplate::class, 'performance_template_id');
    }

    public function performanceCategory()
    {
        return $this->belongsTo(PerformanceCategory::class, 'performance_categories');
    }

}
