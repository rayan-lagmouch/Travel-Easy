<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('employee.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $bookings = Booking::all()->map(function ($booking) {
            $booking->seat_number = Str::upper($booking->seat_number);
            return $booking;
        });

        return view('employee.invoices.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seat_number' => [
                'required',
                'exists:bookings,seat_number',
                function ($attribute, $value, $fail) {
                    $booking = Booking::where('seat_number', Str::upper($value))->first();
                    if ($booking && Invoice::where('booking_id', $booking->id)->exists()) {
                        $fail('Seat number already in use.');
                    }
                },
            ],
            'invoice_date' => 'required|date',
            'amount_ex_vat' => 'required|numeric|min:0',
            'invoice_status' => 'required|string|in:pending,paid,cancelled',
            'remarks' => 'nullable|string|max:255',
        ]);

        $booking = Booking::where('seat_number', Str::upper($request->seat_number))->firstOrFail();

        // Ensure a unique invoice number
        do {
            $invoiceNumber = 'INV-' . strtoupper(uniqid());
        } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

        // Auto-calculate VAT (21%) and Amount incl. VAT
        $vat = round($request->amount_ex_vat * 0.21, 2);
        $amount_inc_vat = round($request->amount_ex_vat + $vat, 2);

        Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $request->invoice_date,
            'amount_ex_vat' => $request->amount_ex_vat,
            'vat' => $vat,
            'amount_inc_vat' => $amount_inc_vat,
            'invoice_status' => $request->invoice_status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
    }
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }
}
