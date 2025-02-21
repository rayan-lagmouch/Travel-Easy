<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a person for the admin
        $adminPerson = Person::create([
            'first_name' => 'shane',
            'last_name' => 'hamid',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
        ]);

        // Create the admin user
        User::create([
            'person_id' => $adminPerson->id,
            'role' => 'admin', // Add this line
            'name' => 'kaas',
            'email' => 'admin@laravel.com',
            'password' => Hash::make('123456'),
        ]);

        // Create a person for the employee
        $employeePerson = Person::create([
            'first_name' => 'kees',
            'last_name' => 'lagmouch',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
        ]);

        // Create the employee user
        User::create([
            'person_id' => $employeePerson->id,
            'role' => 'employee', // Add this line
            'name' => 'robin',
            'email' => 'employee@laravel.com',
            'password' => Hash::make('123456'),
        ]);

        // Create a person for the regular user
        $userPerson = Person::create([
            'first_name' => 'riyan',
            'last_name' => 'logmach',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
        ]);

        // Create the regular user
        User::create([
            'person_id' => $userPerson->id,
            'role' => 'user', // Add this line
            'name' => 'hamid',
            'email' => 'user@laravel.com',
            'password' => Hash::make('123456'),
        ]);

        dd('Seeding completed'); // Debugging line
    }
}
