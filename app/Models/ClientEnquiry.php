<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ClientEnquiry extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['client_id', 'content', 'subject', 'resolved'];

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(EnquiryResponse::class, 'enquiry_id', 'id');
    }
    
    public function isResolved()
    {
        return $this->resolved;
    }

    public function isClientResponse()
    {
        return $this->responses->where('is_client_reply', true)->count() > 0;
    }
}
