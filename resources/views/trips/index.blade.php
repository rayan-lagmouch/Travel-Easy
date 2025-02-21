<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trips Overview') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div id="success-message" class="bg-green-500 text-white p-4 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="mb-4 flex justify-between items-center">
                        <div class="w-1/3">
                            <input type="text" id="searchInput" placeholder="Search based on destination..." class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <a href="{{ route('trips.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Add a new trip
                        </a>
                    </div>
                    <h3 class="text-lg font-semibold mb-4">Trip List</h3>
                    @if ($trips->count() > 0)
                        <table class="w-full text-left border-collapse" id="tripsTable">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">Destination</th>
                                <th class="border px-4 py-2">Flight Number</th>
                                <th class="border px-4 py-2">Departure Date</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trips as $trip)
                                <tr>
                                    <td class="border px-4 py-2">{{ $trip->destination->country }}</td>
                                    <td class="border px-4 py-2">{{ $trip->flight_number }}</td>
                                    <td class="border px-4 py-2">{{ $trip->departure_date }}</td>
                                    <td class="border px-4 py-2">{{ $trip->trip_status }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('trips.edit', $trip) }}" class="text-blue-500">Bewerken</a>
                                        <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Weet je zeker dat je deze trip wilt verwijderen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Verwijderen</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">There Arent any trips available at the moment</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            let filter = this.value.toLowerCase();
            let tableRows = document.querySelectorAll("#tripsTable tbody tr");
            let found = false;
            tableRows.forEach(row => {
                let destination = row.getElementsByTagName("td")[0].textContent.toLowerCase();
                if (destination.includes(filter)) {
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
                    noResultsMessage.textContent = "No trips found with this destination";
                    document.querySelector("#tripsTable").insertAdjacentElement("afterend", noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }
        });

        window.onload = function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        };
    </script>
</x-app-layout>
