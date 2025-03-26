<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class BookingController extends Controller
{
    // ✅ Overzicht van boekingen per gebruiker met relaties
    public function index()
    {
        $bookings = Booking::where('customer_id', Auth::id())
            ->with(['customer', 'trip', 'invoices']) // Laad de relaties
            ->orderBy('purchase_date', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'flight_number' => 'required|exists:trips,flight_number', // Validate the flight number exists
            'seat_number' => [
                'required',
                'string', // Ensure the seat number is a string
                function ($attribute, $value, $fail) {
                    $booking = Booking::where('seat_number', Str::upper($value))->first(); // Look for the seat number in the bookings table
                    if ($booking) {
                        $fail('Seat number already in use.');
                    }
                },
            ],



            'purchase_date' => 'required|date',
            'purchase_time' => 'required',
            'booking_status' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Retrieve the trip by flight_number
        $trip = Trip::where('flight_number', $validatedData['flight_number'])->first();

        Booking::create([
            'customer_id' => Auth::id(),
            'trip_id' => $trip->id, // Use the trip_id retrieved from the flight_number
            'seat_number' => $validatedData['seat_number'],
            'purchase_date' => $validatedData['purchase_date'],
            'purchase_time' => $validatedData['purchase_time'],
            'booking_status' => $validatedData['booking_status'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
            'special_requests' => $validatedData['special_requests'] ?? null,
            'is_active' => $validatedData['is_active'] ?? true,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Boeking succesvol aangemaakt!');
    }





    public function create()
    {
        // Fetch all bookings and make seat numbers uppercase
        $bookings = Booking::all()->map(function ($booking) {
            $booking->seat_number = Str::upper($booking->seat_number);
            return $booking;
        });

        // Fetch all trips to show flight numbers in the form
        $trips = Trip::all();

        // Pass both bookings and trips to the view
        return view('admin.bookings.create', compact('bookings', 'trips'));
    }


    public function delete()
    {
        return view('admin.bookings.create');
    }
}
