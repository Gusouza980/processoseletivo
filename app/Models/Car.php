<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Car extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'model', 'make', 'year',
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $hidden = [
        'deleted_at', 'pivot', 'created_at', 'updated_at',
    ];

    // RELATIONS
    public function users(){
        return $this->belongsToMany(User::class, "user_cars")->withTimestamps();
    }
}


