<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable ,CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'country_id', 'photo', 'bio', 'email_verified_at', 'mobile', 'lang', 'google_id',
        'provider',
    ];

    protected $dates = [
        'email_verified_at',
    ];


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
        ];
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function freelancer()
    {
        return $this->hasOne(Freelancer::class);
    }


    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
