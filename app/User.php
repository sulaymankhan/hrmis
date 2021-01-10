<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function center(){
        return $this->belongsTo(\App\Center::class);
    }

    public static function createAdminUser(){
        $u = new User;
        $u->name="Admin";
        $u->role ='admin';
        $u->email='admin@nsia.gov.af';
        $u->center_id=1;
        $u->password=bcrypt('Password283!');
        $u->save();
        return $u->createToken('admin')->accessToken;
    }
}
