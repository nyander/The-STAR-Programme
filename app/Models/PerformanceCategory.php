<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceCategory extends Model
{
    use HasFactory;
    protected $table = 'performance_categories';

    // Define the fillable fields if needed
    protected $fillable = [
        'category', 'colour'
    ];
}
