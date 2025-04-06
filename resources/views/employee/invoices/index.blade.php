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
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Invoices</h3>
                        <a href="{{ route('invoices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600">
                            Create New Invoice
                        </a>
                    </div>



                    <!-- Search Input -->
                    <input type="text" id="searchInput" placeholder="Search by Invoice Number"
                           class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           onkeyup="filterInvoices()">

                    @if (session('error'))
                        <div class="bg-red-100 text-red-800 px-4 py-2 rounded-md mb-4">
                            {{ session('error') }}
                        </div>
                    @endif


                @if ($invoices->isEmpty())
                        <p class="text-gray-500 text-center">No Invoices Found</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 rounded-md text-gray-800 dark:text-gray-200" id="invoiceTable">
                                <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
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
                                    <tr class="invoice-row hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border px-4 py-2 invoice-number">{{ $invoice->invoice_number }}</td>
                                        <td class="border px-4 py-2">{{ $invoice->booking->seat_number }}</td>
                                        <td class="border px-4 py-2">€{{ number_format($invoice->amount_ex_vat, 2) }}</td>
                                     </td>
                                        <td class="border px-4 py-2">€{{ number_format($invoice->amount_inc_vat, 2) }}</td>
                                        <td class="border px-4 py-2">
                                                <span class="px-2 py-1 rounded-md text-white
                                                    {{ $invoice->invoice_status === 'paid' ? 'bg-green-500' : ($invoice->invoice_status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                    {{ ucfirst($invoice->invoice_status) }}
                                                </span>
                                        </td>
                                        <td class="border px-4 py-2 space-x-2">
                                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-green-500 hover:underline">Read</a>
                                            <a href="{{ route('invoices.download', $invoice->id) }}"
                                               class="bg-blue-500 text-white px-3 py-1 rounded-md shadow hover:bg-blue-600">
                                                Download PDF
                                            </a>

                                            <form action="{{ route('invoices.cancel', $invoice->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="bg-orange-500 text-white px-3 py-1 rounded-md shadow hover:bg-orange-600"
                                                        onclick="return confirm('Are you sure you want to cancel this invoice?')">
                                                    Cancel
                                                </button>
                                            </form>


                                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md shadow hover:bg-red-600"
                                                        onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterInvoices() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll(".invoice-row");

            rows.forEach(row => {
                let invoiceNumber = row.querySelector(".invoice-number").textContent.toLowerCase();
                row.style.display = invoiceNumber.includes(input) ? "" : "none";
            });
        }
    </script>
</x-app-layout>
