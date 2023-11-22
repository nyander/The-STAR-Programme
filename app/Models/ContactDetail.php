<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'city',
        'state',
        'postal_code',
        'country',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
