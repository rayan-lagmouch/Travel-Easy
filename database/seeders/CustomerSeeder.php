<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Person; // Make sure to import the Person model to handle the foreign key relationship

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Ensure a person exists first (this should be handled by the PersonSeeder ideally)
        $person = Person::firstOrCreate([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
        ]);

        // Create or update customer record
        Customer::firstOrCreate([
            'person_id' => $person->id, // Link to the person we just created or found
        ], [
            'relation_number' => 'CUST123', // Unique identifier for the customer
            'email' => 'john.doe@example.com', // Optional, since it's nullable in migration
            'is_active' => true, // Active status
            'remarks' => 'Test customer', // Optional remarks
        ]);
    }
}
