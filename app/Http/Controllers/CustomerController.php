<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Person;

class CustomerController extends Controller
{
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


    public function create()
    {
        return view('admin.customers.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ], [
            'first_name.required' => 'fill the first name',
            'last_name.required' => 'fill the last name',
            'email.required' => 'fill the email',
            'phone.required' => 'fill the phone number ',
        ]);

        // Create a new Person with the phone number
        $person = Person::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,  // Saving the phone number here
            'remarks' => $request->remarks,
        ]);

        // Create a new Customer linked to the Person
        $customer = Customer::create([
            'person_id' => $person->id,
            'relation_number' => 'REL-' . rand(1000, 9999),
            'is_active' => true,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer added successfully!');
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        session()->flash('success', 'Customer successfully updated');
        return redirect()->route('admin.customers.index');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        session()->flash('success', 'Customer successfully deleted');
        return redirect()->route('admin.customers.index');
    }
}
