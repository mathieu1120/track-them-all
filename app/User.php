<?php

namespace App;

use App\Models\Groups;
use App\Models\GroupUserMaps;
use App\Models\UserLocations;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public function groups() {
        return $this->hasMany(Groups::class);
    }

    public function location() {
        return $this->hasOne(UserLocations::class);
    }

    public function isInGroups() {
        return $this->belongsToMany(Groups::class, 'group_user_maps', null, 'group_id');
    }
}
