<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['customer.person', 'trip.destination'])
            ->orderBy('purchase_date', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $bookings = Booking::all()->map(function ($booking) {
            $booking->seat_number = Str::upper($booking->seat_number);
            return $booking;
        });

        $trips = Trip::all();
        return view('admin.bookings.create', compact('bookings', 'trips'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'flight_number' => 'required|exists:trips,flight_number',
            'seat_number' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (Booking::where('seat_number', Str::upper($value))->exists()) {
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

        $trip = Trip::where('flight_number', $validatedData['flight_number'])->first();

        Booking::create([
            'customer_id' => Auth::id(),
            'trip_id' => $trip->id,
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

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $trips = Trip::all();

        return view('admin.bookings.edit', compact('booking', 'trips'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validatedData = $request->validate([
            'flight_number' => 'required|exists:trips,flight_number',
            'seat_number' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($id) {
                    if (Booking::where('seat_number', Str::upper($value))
                        ->where('id', '!=', $id)
                        ->exists()) {
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

        $trip = Trip::where('flight_number', $validatedData['flight_number'])->first();

        $booking->update([
            'trip_id' => $trip->id,
            'seat_number' => Str::upper($validatedData['seat_number']),
            'purchase_date' => $validatedData['purchase_date'],
            'purchase_time' => $validatedData['purchase_time'],
            'booking_status' => $validatedData['booking_status'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
            'special_requests' => $validatedData['special_requests'] ?? null,
            'is_active' => $validatedData['is_active'] ?? true,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Boeking succesvol bijgewerkt!');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        if (!$booking->is_active) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Boeking is inactive and cannot be deleted');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Boeking succesvol verwijderd.');
    }

}
