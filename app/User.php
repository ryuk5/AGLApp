<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'region', 'tel'
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

    //user appartient a un role
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    //él user ya3méll plusieures livrasion ki yabda un livreur (exp : dans le cas un livreur fi sousse 3mal plusieures livraisions)
    public function deliveries()
    {
        return $this->hasMany('App\Delivery'); 
    }

    //él user ya3méll plusieures donts ki yabda donneur
    public function donations()
    {
        return $this->hasMany('App\Donation'); 
    }

    //él user ya3méll plusieures demandes ki yabda demandeure
    public function demands()
    {
        return $this->hasMany('App\Demand');
    }

    //Une fonction traj3na role bta3 él user
    public function hasRole($role)
    {
        if($this->role->name == $role)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
