<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Employee;
use App\Models\Location;
use Illuminate\Http\Request;

class TripController extends Controller
{
    // Show all trips with search functionality (optional)
    public function index(Request $request)
    {
        $query = Trip::with(['employee', 'departure', 'destination']); // Eager load relationships

        // Optionally, you can add search functionality here (e.g., filter by status or employee)
        if ($request->has('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('last_name', 'like', '%' . $request->search . '%');
            });
        }

        // Fetch all trips
        $trips = $query->get();

        return view('trips.index', compact('trips'));
    }

    // Show the form to add a new trip
    public function create()
    {
        $employees = Employee::all(); // Assuming Employee model exists
        $locations = Location::all(); // Assuming Location model exists

        return view('trips.create', compact('employees', 'locations'));
    }

    // Store a new trip
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'departure_id' => 'required|integer|exists:locations,id',
            'destination_id' => 'required|integer|exists:locations,id',
            'flight_number' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|date_format:H:i',
            'trip_status' => 'required|string',
            'remarks' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ], [
            'employee_id.required' => 'Please select an employee',
            'departure_id.required' => 'Please select a departure location',
            'destination_id.required' => 'Please select a destination location',
            'flight_number.required' => 'Please enter the flight number',
            'departure_date.required' => 'Please select the departure date',
            'departure_time.required' => 'Please enter the departure time',
            'arrival_date.required' => 'Please select the arrival date',
            'arrival_time.required' => 'Please enter the arrival time',
            'trip_status.required' => 'Please select the trip status',
        ]);

        // Create a new trip
        Trip::create([
            'employee_id' => $request->employee_id,
            'departure_id' => $request->departure_id,
            'destination_id' => $request->destination_id,
            'flight_number' => $request->flight_number,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'arrival_date' => $request->arrival_date,
            'arrival_time' => $request->arrival_time,
            'trip_status' => $request->trip_status,
            'remarks' => $request->remarks,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('trips.index')->with('success', 'Trip successfully created!');
    }

    // Show the form to edit a trip
    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        $employees = Employee::all(); // Assuming Employee model exists
        $locations = Location::all(); // Assuming Location model exists

        return view('trips.edit', compact('trip', 'employees', 'locations'));
    }

    // Update an existing trip
    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'departure_id' => 'required|integer|exists:locations,id',
            'destination_id' => 'required|integer|exists:locations,id',
            'flight_number' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|date_format:H:i',
            'trip_status' => 'required|string',
            'remarks' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Update the trip
        $trip->update([
            'employee_id' => $request->employee_id,
            'departure_id' => $request->departure_id,
            'destination_id' => $request->destination_id,
            'flight_number' => $request->flight_number,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'arrival_date' => $request->arrival_date,
            'arrival_time' => $request->arrival_time,
            'trip_status' => $request->trip_status,
            'remarks' => $request->remarks,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('trips.index')->with('success', 'Trip successfully updated!');
    }

    // Delete a trip
    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);

        // Delete the trip
        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Trip successfully deleted!');
    }
}
