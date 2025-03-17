<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define relationship to 'Person' model
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function getFullNameAttribute()
    {
        return $this->person ? $this->person->first_name . ' ' . ($this->person->middle_name ? $this->person->middle_name . ' ' : '') . $this->person->last_name : 'N/A';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', // Keeping the 'name' field
        'email',
        'password',
        'role', // You can store the role here
        'person_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an employee.
     */
    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    /**
     * Check if the user is a general user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}

