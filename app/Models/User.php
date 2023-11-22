<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function performanceProfileTemplate(): HasMany
    {
        return $this->hasMany(PerformanceProfileTemplate::class); 
    }

    public function performanceProfile(): HasMany
    {
        return $this->hasMany(PerformanceProfile::class, 'client_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function clientAgreement()
    {
        return $this->hasOne(ClientAgreement::class, 'user_id');
    }

    public function clientGoals(): HasMany
    {
        return $this->hasMany(ClientGoal::class, 'client_id');
    }

    public function clientOverview(): HasOne
    {
        return $this->hasOne(ClientOverview::class, 'user_id');
    }

    public function contact(): HasOne
    {
        return $this->hasOne(ContactDetail::class);
    }

    public function enquiries() : HasMany
    {
        return $this->hasMany(ClientEnquiry::class, 'client_id');
    }

    
}
