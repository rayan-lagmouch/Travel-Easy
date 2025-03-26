<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Edit Invoice</h3>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seat Number:</label>
                            <select name="seat_number" class="w-full p-3 mt-1 border rounded-md shadow-sm" required>
                                @foreach ($bookings as $booking)
                                    <option value="{{ $booking->seat_number }}" {{ old('seat_number', $invoice->booking->seat_number) == $booking->seat_number ? 'selected' : '' }}>
                                        {{ $booking->seat_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seat_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice Date:</label>
                            <input type="date" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}" class="w-full p-3 mt-1 border rounded-md shadow-sm" required>
                            @error('invoice_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (excl. VAT):</label>
                            <input type="number" step="0.01" name="amount_ex_vat" id="amount_ex_vat" value="{{ old('amount_ex_vat', $invoice->amount_ex_vat) }}" class="w-full p-3 mt-1 border rounded-md shadow-sm" required>
                            @error('amount_ex_vat')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">VAT (21%):</label>
                            <input type="number" step="0.01" name="vat" id="vat" value="{{ old('vat', $invoice->vat) }}" class="w-full p-3 mt-1 border rounded-md shadow-sm" readonly>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (incl. VAT):</label>
                            <input type="number" step="0.01" name="amount_inc_vat" id="amount_inc_vat" value="{{ old('amount_inc_vat', $invoice->amount_inc_vat) }}" class="w-full p-3 mt-1 border rounded-md shadow-sm" readonly>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice Status:</label>
                            <select name="invoice_status" class="w-full p-3 mt-1 border rounded-md shadow-sm" required>
                                <option value="pending" {{ old('invoice_status', $invoice->invoice_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('invoice_status', $invoice->invoice_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('invoice_status', $invoice->invoice_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('invoice_status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Remarks:</label>
                            <textarea name="remarks" class="w-full p-3 mt-1 border rounded-md shadow-sm">{{ old('remarks', $invoice->remarks) }}</textarea>
                            @error('remarks')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-700">
                            Update Invoice
                        </button>

                        <a href="{{ route('invoices.index') }}" class="ml-4 bg-gray-500 text-white px-6 py-3 rounded-md shadow-md hover:bg-gray-600">
                            Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const amountExVatInput = document.querySelector("#amount_ex_vat");
        const vatInput = document.querySelector("#vat");
        const amountIncVatInput = document.querySelector("#amount_inc_vat");

        amountExVatInput.addEventListener("input", function () {
            let amountExVat = parseFloat(this.value) || 0;
            let vat = (amountExVat * 0.21).toFixed(2);
            let amountIncVat = (amountExVat + parseFloat(vat)).toFixed(2);

            vatInput.value = vat;
            amountIncVatInput.value = amountIncVat;
        });
    });
</script>
