<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- ✅ Search field and Add button -->
                    <div class="mb-4 flex justify-between items-center">
                        <div class="w-1/3">
                            <input type="text" id="searchInput" placeholder="Search by customer name..."
                                   class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <a href="{{ route('employee.bookings.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            New Booking
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Bookings Overview</h3>
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($bookings->isEmpty())
                        <p class="text-gray-500">No bookings found.</p>
                    @else
                        <table class="w-full text-left border-collapse" id="bookingTable">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">Customer</th>
                                <th class="border px-4 py-2">Destination</th>
                                <th class="border px-4 py-2">Seat Number</th>
                                <th class="border px-4 py-2">Price</th>
                                <th class="border px-4 py-2">Quantity</th>
                                <th class="border px-4 py-2">Requests</th>
                                <th class="border px-4 py-2">Date</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bookings as $booking)
                                <tr>

                                    <td class="border px-4 py-2"> {{ ($booking->customer->person)->first_name . ' ' . ($booking->customer->person)->middle_name . ' ' . ($booking->customer->person)->last_name }}</td>
                                    <td class="border px-4 py-2">{{ $booking->trip->destination->country . ': ' . $booking->trip->destination->airport }}</td>
                                    <td class="border px-4 py-2">{{ $booking->seat_number }}</td>
                                    <td class="border px-4 py-2">€{{ number_format($booking->price, 2) }}</td>
                                    <td class="border px-4 py-2">{{ $booking->quantity }}</td>
                                    <td class="border px-4 py-2">{{ $booking->special_requests }}</td>
                                    <td class="border px-4 py-2">{{ $booking->purchase_date . ' - ' .$booking->purchase_time }}</td>
                                    <td class="border px-4 py-2 {{ $booking->is_active ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $booking->is_active ? 'Active' : 'Canceled' }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="#" class="text-blue-500 mr-2">Edit</a>

                                        <form action="{{ route('employee.bookings.destroy', $booking->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <form action="{{ route('employee.bookings.cancel', $booking->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                    class="text-orange-500 hover:text-orange-700">
                                                Cancel
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Search function -->
    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            let filter = this.value.toLowerCase();
            let tableBody = document.querySelector("#bookingTable tbody");
            let tableRows = tableBody.querySelectorAll("tr");

            let matchFound = false;

            tableRows.forEach(row => {
                let nameCell = row.getElementsByTagName("td")[0]; // Get customer name
                let customerName = nameCell.textContent.trim().toLowerCase();

                if (customerName.includes(filter)) {
                    row.style.display = "";
                    matchFound = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Show "No results" message if nothing is found
            let noResultRow = document.getElementById("noResultRow");
            if (noResultRow) {
                noResultRow.remove();
            }

            if (!matchFound) {
                let newRow = document.createElement("tr");
                newRow.id = "noResultRow";
                newRow.innerHTML = `<td colspan="7" class="border px-4 py-2 text-center text-gray-500">No bookings found</td>`;
                tableBody.appendChild(newRow);
            }
        });
    </script>

</x-app-layout>
