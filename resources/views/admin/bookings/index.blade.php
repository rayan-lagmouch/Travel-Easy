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

                    <!-- ✅ Zoekveld en Toevoegknop -->
                    <div class="mb-4 flex justify-between items-center">
                        <div class="w-1/3">
                            <input type="text" id="searchInput" placeholder="Zoek op klantnaam..."
                                   class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <a href="{{ route('admin.bookings.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Nieuwe Boeking
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Boekingen Overzicht</h3>

                    @if ($bookings->isEmpty())
                        <p class="text-gray-500">Geen boekingen gevonden.</p>
                    @else
                        <table class="w-full text-left border-collapse" id="bookingTable">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">Klant</th>
                                <th class="border px-4 py-2">Bestemming</th>
                                <th class="border px-4 py-2">Stoelnummer</th>
                                <th class="border px-4 py-2">Prijs</th>
                                <th class="border px-4 py-2">Aantal</th>
                                <th class="border px-4 py-2">Verzoeken</th>
                                <th class="border px-4 py-2">Datum</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Acties</th>
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
                                        {{ $booking->is_active ? 'Actief' : 'Geannuleerd' }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="#" class="text-blue-500 mr-2">Bewerken</a>

                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Verwijderen</button>
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

    <!-- ✅ Zoekfunctie -->
    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            let filter = this.value.toLowerCase();
            let tableBody = document.querySelector("#bookingTable tbody");
            let tableRows = tableBody.querySelectorAll("tr");

            let matchFound = false;

            tableRows.forEach(row => {
                let nameCell = row.getElementsByTagName("td")[0]; // Klantnaam ophalen
                let customerName = nameCell.textContent.trim().toLowerCase();

                if (customerName.includes(filter)) {
                    row.style.display = "";
                    matchFound = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Geen resultaten tonen als niets gevonden wordt
            let noResultRow = document.getElementById("noResultRow");
            if (noResultRow) {
                noResultRow.remove();
            }

            if (!matchFound) {
                let newRow = document.createElement("tr");
                newRow.id = "noResultRow";
                newRow.innerHTML = `<td colspan="7" class="border px-4 py-2 text-center text-gray-500">Geen boekingen gevonden</td>`;
                tableBody.appendChild(newRow);
            }
        });
    </script>

</x-app-layout>
