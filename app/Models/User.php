<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'country_id', 'photo', 'bio', 'email_verified_at', 'mobile', 'lang', 'google_id',
        'provider', 'birth_date', 'available_hire', 'gender','save_data','video_title','images_title','video','mobile_verified_at','status_reason'
    ];

    protected $dates = [
        'email_verified_at',
    ];

    public function getBirthDateAttribute()
    {
        return isset($this->attributes['birth_date']) && $this->attributes['birth_date']
            ? date('Y-m-d')
            : null;
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'available_hire' => 'boolean',
            'languages' => 'array',
        ];
    }

    public function getImageUrl():string
    {
        return $this->getFirstMediaUrl('photo','thumb') ?: url('logos/favicon.png');
    }


    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }



    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }


    public function freelancer():HasOne
    {
        return $this->hasOne(Freelancer::class);
    }


    public function otpCodes():HasMany
    {
        return $this->hasMany(OtpCode::class);
    }

    public function notifications():HasMany
    {
        return $this->hasMany(Notification::class);
    }


    public function skills():BelongsToMany
    {
        return $this->belongsToMany(Skills::class, 'freelancers_skills', 'freelancer_id', 'skill_id')
            ->withTimestamps();
    }


}
