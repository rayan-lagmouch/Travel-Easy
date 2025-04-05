<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Person;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Show all customers with search functionality
    public function index(Request $request)
    {
        $query = Customer::with('person'); // Ensure the 'person' relationship is loaded

        // Search by last name if a search query is provided
        if ($request->has('search')) {
            $query->whereHas('person', function ($q) use ($request) {
                $q->where('lastname', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->get();

        return view('admin.customers.index', compact('customers'));
    }

    // Show the form to add a new customer
    public function create()
    {
        return view('admin.customers.create');
    }

    // Store a new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'is_active' => 'required|boolean',  // Validate the is_active field
        ], [
            'first_name.required' => 'Please enter the first name',
            'last_name.required' => 'Please enter the last name',
            'email.required' => 'Please enter the email address',
            'phone.required' => 'Please enter the phone number',
        ]);

        // Create a new Person with the provided details
        $person = Person::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'remarks' => $request->remarks,
        ]);

        // Create a new Customer linked to the Person
        $customer = Customer::create([
            'person_id' => $person->id,
            'relation_number' => 'REL-' . rand(1000, 9999),
            'is_active' => $request->is_active,  // Set the is_active status
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer successfully added!');
    }

    // Show the form to edit a customer
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    // Update the customer information
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:255',
            'is_active' => 'required|boolean',  // Validate the is_active field
        ]);

        // Update the related person's details
        $customer->person->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'remarks' => $request->remarks,
        ]);

        // Update the customer details
        $customer->update([
            'is_active' => $request->is_active,  // Update the is_active status
            'remarks' => $request->remarks,
        ]);

        session()->flash('success', 'Customer successfully updated');
        return redirect()->route('admin.customers.index');
    }

    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Check if the customer is active
        if ($customer->is_active === false) {
            // If the customer is inactive, show error message
            return redirect()->route('admin.customers.index')->with('error', 'Customer is inactive and cannot be deleted');
        }

        // Delete the related person and customer if the customer is active
        if ($customer->person) {
            $customer->person->delete(); // Delete the associated person
        }

        $customer->delete(); // Delete the customer

        return redirect()->route('admin.customers.index')->with('success', 'Customer successfully deleted');
    }
}
