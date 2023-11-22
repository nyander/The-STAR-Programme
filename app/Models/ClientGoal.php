<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'type',
        'goal',
        'complete',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class);
    }
}
