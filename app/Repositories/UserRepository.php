<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public static function getUsers() : Collection
    {
        return User::get();
    }
    
    public static function getUserById(int $id) : Collection
    {
        return User::where('id',$id)->get();
    }

    public static function getLastUser() : User
    {
        return User::last();
    }
}