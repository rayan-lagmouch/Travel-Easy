<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Person; // Import the Person model
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Define validation rules for form inputs
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Create a new person record
            $person = Person::create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'is_active' => true, // Default value
            ]);

            // Create a new user record (without username, using 'role' instead)
            $user = User::create([
                'person_id' => $person->id,
                'name' => $validated['first_name'] . ' ' . $validated['last_name'], // Combine first and last name
                'email' => $validated['email'],
                'role' => 'user', // Default role is 'user', you can customize this as needed
                'password' => Hash::make($validated['password']),
                'is_active' => true, // Default value
            ]);

            // Trigger Registered event
            event(new Registered($user));

            // Log in the user immediately after registration
            Auth::login($user);

            // Redirect to the dashboard
            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            // Handle any exceptions
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }





}
