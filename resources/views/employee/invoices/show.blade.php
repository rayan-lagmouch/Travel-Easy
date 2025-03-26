<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoice Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6">Invoice #{{ $invoice->invoice_number }}</h3>

                    <div class="grid grid-cols-2 gap-6">
                        <p class="text-lg"><strong class="font-semibold text-gray-700 dark:text-gray-300">Seat Number:</strong> {{ $invoice->booking->seat_number }}</p>
                        <p class="text-lg"><strong class="font-semibold text-gray-700 dark:text-gray-300">Amount (€):</strong> {{ number_format($invoice->amount_ex_vat, 2) }}</p>
                        <p class="text-lg"><strong class="font-semibold text-gray-700 dark:text-gray-300">VAT (€):</strong> {{ number_format($invoice->vat, 2) }}</p>
                        <p class="text-lg"><strong class="font-semibold text-gray-700 dark:text-gray-300">Total (€):</strong> {{ number_format($invoice->amount_inc_vat, 2) }}</p>
                        <p class="text-lg"><strong class="font-semibold text-gray-700 dark:text-gray-300">Status:</strong> <span class="px-3 py-1 rounded-md {{ $invoice->invoice_status === 'paid' ? 'bg-green-600 text-white' : 'bg-yellow-500 text-black' }}">{{ ucfirst($invoice->invoice_status) }}</span></p>
                        <p class="text-lg"><strong class="font-semibold text-gray-700 dark:text-gray-300">Remarks:</strong> {{ $invoice->remarks ?? 'None' }}</p>
                    </div>

                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition">Edit</a>
                        <a href="#" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md transition">Download</a>
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-md transition">Delete</button>
                        </form>
                        <a href="{{ route('invoices.index') }}" class="ml-auto px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
