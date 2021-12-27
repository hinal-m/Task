<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Admin extends User
{
    use HasFactory, HasApiTokens,Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function getProfileAttribute($value)
    {
        return $value ? asset('storage/profile' . '/' . $value) : NULL;
    }
}
