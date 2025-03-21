<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Communication;
use App\Models\Employee;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public function index()
    {
        return view('employee.communications.index', [
            'employees' => Employee::with(['communications', 'person'])->get()
        ]);
    }

    public function create()
    {
        return view('employee.communications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:255',
            'email' => 'required|email',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Haal de medewerker op via authenticated user
        $employee = Auth::user();

        // Controleer of de gebruiker een medewerker is
        if (!$employee || !$employee->employee_type) {
            return redirect()->back()->with('error', 'Je moet als medewerker ingelogd zijn om berichten te versturen.');
        }

        Communication::create([
            'employee_id' => $employee->id,
            'title' => $request->title,
            'message' => $request->message,
            'email' => $request->email,
            'sent_at' => now(),
            'is_active' => true,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('communications.index')->with('success', 'Bericht succesvol toegevoegd.');
    }




    public function edit(string $id)
    {
        $communication = Communication::findOrFail($id);
        return view('employee.communications.edit', compact('communication'));
    }

    public function update(Request $request, string $id)
    {
        $communication = Communication::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:255',
            'email' => 'required|email',
            'remarks' => 'nullable|string|max:255',
        ]);

        $communication->update($request->all());

        return redirect()->route('communications.index')->with('success', 'Bericht succesvol bijgewerkt.');
    }


    public function destroy(string $id)
    {
        $communication = Communication::findOrFail($id);
        $communication->delete();

        session()->flash('success', 'Bericht succesvol verwijderd');
        return redirect()->route('communications.index');
    }


}
