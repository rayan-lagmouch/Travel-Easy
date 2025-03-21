<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::firstOrCreate([
            'id' => 1, // Ensure this ID matches what you reference in the bookings table
        ], [
            'person_id' => 1, // References the person created in PersonSeeder
            'email' => '123@gmail.com',
            'relation_number' => 'CUST123',
            'is_active' => true,
            'remarks' => 'Test customer',
        ]);
    }
}
