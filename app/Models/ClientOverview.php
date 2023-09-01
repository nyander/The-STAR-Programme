<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOverview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'performanceProfile_id',
        'current_sport',
        'experience_level',
        'previous_achievements',
        'athletic_background',
        'injuries',
        'medical_conditions',
        'allergies',
        'rating',
        'client_experience',
        'client_positive_feedback',
        'client_areas_to_improve',
        'client_challenges',
        'client_testimonies',
        'client_comments',
        'client_completion',
        'practitioner_client_achieve',
        'practitioner_progress_review',
        'practitioner_achievement_review',
        'practitioner_challenge_review',
        'practitioner_support',
        'practitioner_suggestion',
        'practitioner_completion',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
