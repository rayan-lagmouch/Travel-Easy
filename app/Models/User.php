<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function getFullNameAttribute()
    {
        return $this->person ? $this->person->first_name . ' ' . ($this->person->middle_name ? $this->person->middle_name . ' ' : '') . $this->person->last_name : 'N/A';
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'person_id',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
