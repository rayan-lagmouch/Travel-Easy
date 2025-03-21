<?php

// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['person_id', 'relation_number', 'is_active', 'remarks'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }
}
