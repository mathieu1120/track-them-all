<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Groups extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'password',
    ];

    protected $attributes = [
        'active' => 1,
        'password' => ''
    ];

    protected $hidden = [
        'password'
    ];

    public function toArray()
    {

        $array = parent::toArray();
        $array['private'] = !!$this->password;
        return $array;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function isPrivateGroup() {
        return !!$this->password;
    }

    public function isCorrectPassword($password) {
        return Hash::check($password, $this->password);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'group_user_maps', 'group_id', 'user_id');
    }
}