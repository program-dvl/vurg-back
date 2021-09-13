<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    // use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'preferred_currency',
        'user_timezone',
        'display_name',
        'firstname',
        'lastname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_full_url',
        'firstname_and_initial',
        'full_name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function settings() {
        return $this->hasMany('App\Models\UserSettings','user_id');
    }

    public function currency() {
        return $this->belongsTo('App\Models\Currency','preferred_currency');
    }

    public function timezone() {
        return $this->belongsTo('App\Models\Timezone','timezone');
    }

    public function phonecode() {
        return $this->belongsTo('App\Models\Country','phone_code');
    }

    public function getAvatarFullUrlAttribute()
    {
        if(!empty($this->avatar_image)) {
            return public_path('/user_profile') . '/' .$this->avatar_image;
        }
        return null;
    }

    public function getFirstnameAndInitialAttribute()
    {
        return $this->firstname . " " . substr($this->lastname,0,1);
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . " " . $this->lastname;
    }
}
