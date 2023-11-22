<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedPerformanceProfile extends Model
{
    use HasFactory;

    public function performanceProfileTemplate()
    {
        return $this->belongsTo(PerformanceProfileTemplate::class);
    }
} 
