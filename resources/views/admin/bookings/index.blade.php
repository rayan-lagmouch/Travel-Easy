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

                    {{-- ✅ Flash Messages --}}
                    @if (session('success'))
                        <div id="success-message" class="bg-green-500 text-white p-4 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div id="error-message" class="bg-red-500 text-white p-4 rounded-md mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- ✅ Search field and button --}}
                    <div class="mb-4 flex justify-between items-center">
                        <div class="w-1/3">
                            <input type="text" id="searchInput" placeholder="Search by customer name..."
                                   class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <a href="{{ route('admin.bookings.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            New Booking
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Bookings Overview</h3>

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
                                    <td class="border px-4 py-2">
                                        {{ $booking->customer->person->first_name }}
                                        {{ $booking->customer->person->middle_name }}
                                        {{ $booking->customer->person->last_name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $booking->trip->destination->country }}: {{ $booking->trip->destination->airport }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $booking->seat_number }}</td>
                                    <td class="border px-4 py-2">€{{ number_format($booking->price, 2) }}</td>
                                    <td class="border px-4 py-2">{{ $booking->quantity }}</td>
                                    <td class="border px-4 py-2">{{ $booking->special_requests }}</td>
                                    <td class="border px-4 py-2">{{ $booking->purchase_date }} - {{ $booking->purchase_time }}</td>
                                    <td class="border px-4 py-2 {{ $booking->is_active ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $booking->is_active ? 'Active' : 'Canceled' }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="text-blue-500 mr-2">Edit</a>
                                        <!-- Show Delete Button only if Booking is Active -->
                                        @if ($booking->is_active)
                                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                                                  class="inline-block ml-2"
                                                  onsubmit="return confirmDelete('{{ $booking->seat_number }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-red-500">Inactive booking cannot be deleted</span>
                                        @endif
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

    {{-- ✅ JavaScript --}}
    <script>
        // Flash messages verwijderen
        setTimeout(() => {
            document.getElementById("success-message")?.style.display = "none";
            document.getElementById("error-message")?.style.display = "none";
        }, 3000);

        // Search
        document.getElementById("searchInput").addEventListener("input", function () {
            let filter = this.value.toLowerCase();
            let tableRows = document.querySelectorAll("#bookingTable tbody tr");

            let found = false;
            tableRows.forEach(row => {
                let name = row.getElementsByTagName("td")[0].textContent.toLowerCase();
                if (name.includes(filter)) {
                    row.style.display = "";
                    found = true;
                } else {
                    row.style.display = "none";
                }
            });

            let noResultsMessage = document.getElementById("noResultsMessage");
            if (!found) {
                if (!noResultsMessage) {
                    noResultsMessage = document.createElement("div");
                    noResultsMessage.id = "noResultsMessage";
                    noResultsMessage.className = "bg-red-500 text-white p-4 rounded-md mt-4";
                    noResultsMessage.textContent = "No bookings found with this customer name";
                    document.querySelector("#bookingTable").insertAdjacentElement("afterend", noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }
        });

        // Confirm delete
        function confirmDelete(seatNumber) {
            return confirm(`Weet je zeker dat je de boeking met stoelnummer "${seatNumber}" wilt verwijderen?`);
        }
    </script>
</x-app-layout>
