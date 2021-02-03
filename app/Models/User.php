<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'facebook_id',
        'gender',
        'birthday',
        'address',
        'profile_image_path',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function realty_post()
    {
        return $this->hasMany('App\Models\RealtyPost')->with('realty');
    }

    public function wallet()
    {
        return $this->hasOne('App\Models\AccountBalance', 'user_id', 'id');
    }

    public function featured_realties()
    {
        return $this->belongsToMany('App\Models\RealtyPost', 'user_featured_posts', 'user_id', 'realty_post_id')->with(['realty']);
    }
}