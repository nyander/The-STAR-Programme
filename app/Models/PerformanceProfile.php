<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'performance_template_id',
        'client_id',
        'practitioner_id',
        'practitioner_feedback',
        'session',
        'completed'
    ];

    public function performanceProfileTemplate()
    {
        return $this->belongsTo(PerformanceProfileTemplate::class, 'performance_template_id');
    }


    public function answers()
    {
        return $this->hasMany(PerformanceProfileAnswer::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }
}
