<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'preferred_days',
        'preferred_times',
        'program_duration',
        'consent',
        'confidentiality',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
