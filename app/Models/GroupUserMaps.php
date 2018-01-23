<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUserMaps extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'user_id'
    ];

    protected $attributes = [
        'active' => 1
    ];
}