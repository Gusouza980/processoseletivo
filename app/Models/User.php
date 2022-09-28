<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $hidden = [
        'password', 'deleted_at', 'created_at', 'updated_at',
    ];

    // RELATIONS
    public function cars(){
        return $this->belongsToMany(Car::class, "user_cars")->withTimestamps();
    }

    // HASHING PASSWORD BEFORE STORE/UPDATE
    public function setPasswordAttribute($password){
        $this->attributes['password'] = Hash::make($password);
    }
}


