<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryResponse extends Model
{
    use HasFactory;

    protected $fillable = ['enquiry_id', 'response', 'is_client_reply', 'user_id'];


    public function enquiry()
    {
        return $this->belongsTo(ClientEnquiry::class, 'enquiry_id', 'id');
    }

    public function user()
{
  return $this->belongsTo(User::class, 'user_id'); 
}
}
