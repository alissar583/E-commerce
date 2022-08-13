<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     *  $table->integer('phone_number');
    $table->text('facebook_url');
    $table->string('password');
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'facebook_url',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'owner_id')
            ->whereDate('expired_date', '>=', now());
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'owner_id');
    }
    public function likes(){
        return $this->hasMany(like::class, 'owner_id');
    }
}
