<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Invoices</h3>
                    <a href="{{ route('invoices.create') }}" class="text-blue-500 mb-4 inline-block">Create New Invoice</a>
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">Invoice Number</th>
                            <th class="border px-4 py-2">Seat Number</th>
                            <th class="border px-4 py-2">Amount (€)</th>
                            <th class="border px-4 py-2">VAT (€)</th>
                            <th class="border px-4 py-2">Total (€)</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td class="border px-4 py-2">{{ $invoice->invoice_number }}</td>
                                <!-- Replace booking_id with seat_number -->
                                <td class="border px-4 py-2">{{ $invoice->booking->seat_number }}</td>
                                <td class="border px-4 py-2">{{ number_format($invoice->amount_ex_vat, 2) }}</td>
                                <td class="border px-4 py-2">{{ number_format($invoice->vat, 2) }}</td>
                                <td class="border px-4 py-2">{{ number_format($invoice->amount_inc_vat, 2) }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($invoice->invoice_status) }}</td>
                                <td class="border px-4 py-2">
                                    <a href="#" class="text-blue-500">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Back Button -->
                <div class="p-6">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
