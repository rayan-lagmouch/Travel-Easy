<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'employee_number',
        'employee_type',
        'is_active',
        'remarks',
    ];

    /**
     * Define the relationship between Employee and Person.
     * An employee belongs to one person.
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }


}
