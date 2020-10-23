<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class
User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;
    protected $fillable = ['name', 'email', 'password', 'score', 'flag'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
