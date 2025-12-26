<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{

    use  HasRoles, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'first_name',
        'last_name',
        'deletion_reason',
        'email',
        'phone',
        'password',
        'profile_photo',
        'role',
        'status',
        'otp',
        'otp_expired_at',
        'otp_verified_at',
        'password_reset_token',
        'password_reset_token_expires_at',
        'terms_and_conditions',
        'address',
        'zipcode',
        'last_login_at',
        
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


    // implement 2 methods for token get
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function social_media()
    {
        return $this->hasMany(SocialMedias::class,'user_id','id');
    }

    public function truck()
    {
        return $this->belongsTo(TruckManage::class,'truck_id','id');
    }

    public function followers()
{
    return $this->hasMany('App\Models\Follow', 'following_id');
}

public function followings()
{
    return $this->hasMany('App\Models\Follow', 'follower_id');
}

public function receivedReports() {
    return $this->hasMany(ReportUser::class, 'reported_user_id');
}

public function reportsAgainst()
{
    return $this->hasMany(ReportUser::class, 'reported_user_id');
}

 public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    // User's received messages
    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    public function getReportsCountAttribute()
    {
        return $this->reportsAgainst()->count();
    }

}
