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
    // ✅ Booking overview per user with relationships
    public function index()
    {
        $bookings = Booking::with('customer.person', 'trip.destination')->get();
        return view('employee.bookings.index', compact('bookings'));
    }


    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'flight_number' => 'required',
            'seat_number' => 'required',
            'purchase_date' => 'required|date',
            'purchase_time' => 'required|date_format:H:i',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        // Set a default customer_id if not provided in the request
        $customerId = $request->input('customer_id', 1); // Default to 1 if no customer_id is provided

        // Find the trip by the provided flight number
        $trip = Trip::where('flight_number', $request->flight_number)->first();

        if (!$trip) {
            return redirect()->back()->withErrors(['flight_number' => 'The selected flight number is invalid.']);
        }

        // Create the booking
        $booking = new Booking([
            'customer_id' => $customerId, // Use the default or provided customer_id
            'trip_id' => $trip->id,
            'seat_number' => $request->seat_number,
            'purchase_date' => $request->purchase_date,
            'purchase_time' => $request->purchase_time,
            'booking_status' => $request->booking_status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'special_requests' => $request->special_requests,
            'is_active' => $request->is_active,
        ]);

        $booking->save();

        // Redirect to bookings list with a success message
        return redirect()->route('employee.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function create()
    {
        $bookings = Booking::all()->map(function ($booking) {
            $booking->seat_number = Str::upper($booking->seat_number);
            return $booking;
        });

        $trips = Trip::all();

        return view('employee.bookings.create', compact('bookings', 'trips')); // 👈 Updated path
    }

    public function delete()
    {
        return view('employee.bookings.create'); // 👈 Updated path
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if (!$booking->is_active) {
            return redirect()->route('employee.bookings.index')
                ->with('error', 'This booking has already been canceled.');
        }

        $booking->is_active = false;
        $booking->save();

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking successfully canceled.');
    }
}
