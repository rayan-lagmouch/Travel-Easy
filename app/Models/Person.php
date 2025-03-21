<?php

// app/Models/Person.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'passport_details',
        'is_active',
        'remarks',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'person_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'person_id');
    }
}
