<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserLocations extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude', 'user_id', 'longitude',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}