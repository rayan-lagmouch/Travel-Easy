<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $bookings = [
            [
                'id' => 1,
                'customer_id' => 1,
                'trip_id' => 1,
                'seat_number' => 'A12',
                'purchase_date' => Carbon::now(),
                'purchase_time' => Carbon::now(),
                'booking_status' => 'confirmed',
                'price' => 100.00,
                'quantity' => 1,
                'special_requests' => 'Window seat',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'customer_id' => 1,
                'trip_id' => 1,
                'seat_number' => 'B15',
                'purchase_date' => Carbon::now(),
                'purchase_time' => Carbon::now(),
                'booking_status' => 'pending',
                'price' => 150.00,
                'quantity' => 2,
                'special_requests' => 'Aisle seat',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'customer_id' => 1,
                'trip_id' => 1,
                'seat_number' => 'C10',
                'purchase_date' => Carbon::now(),
                'purchase_time' => Carbon::now(),
                'booking_status' => 'cancelled',
                'price' => 200.00,
                'quantity' => 1,
                'special_requests' => 'Near exit',
                'is_active' => false,
            ],
            [
                'id' => 4,
                'customer_id' => 1,
                'trip_id' => 1,
                'seat_number' => 'D22',
                'purchase_date' => Carbon::now(),
                'purchase_time' => Carbon::now(),
                'booking_status' => 'confirmed',
                'price' => 120.00,
                'quantity' => 1,
                'special_requests' => 'Extra legroom',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'customer_id' => 1,
                'trip_id' => 1,
                'seat_number' => 'E5',
                'purchase_date' => Carbon::now(),
                'purchase_time' => Carbon::now(),
                'booking_status' => 'pending',
                'price' => 90.00,
                'quantity' => 1,
                'special_requests' => 'No special requests',
                'is_active' => true,
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::firstOrCreate(['id' => $booking['id']], $booking);
        }
    }
}
