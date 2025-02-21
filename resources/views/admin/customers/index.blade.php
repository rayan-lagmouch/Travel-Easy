<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customer Overview') }}
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
                            <input type="text" id="searchInput" placeholder="Search based on Last Name..." class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <a href="{{ route('admin.customers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Add new Customer
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Customer List</h3>

                    @if ($customers->isEmpty())
                        <p class="text-gray-500">There Arent any Customers Registerd at the moment</p>
                    @else
                        <table class="w-full text-left border-collapse" id="customerTable">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">E-mail</th>
                                <th class="border px-4 py-2">Phone Number</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td class="border px-4 py-2">{{ $customer->person->first_name ?? '' }} {{ $customer->person->last_name ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $customer->person->email ?? 'No Email' }}</td>
                                    <td class="border px-4 py-2">{{ $customer->person->phone ?? 'No phone number' }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Delete</button>
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

    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            let filter = this.value.toLowerCase();
            let tableRows = document.querySelectorAll("#customerTable tbody tr");

            let found = false;
            tableRows.forEach(row => {
                let name = row.getElementsByTagName("td")[0].textContent.toLowerCase();
                let lastName = name.split(" ").slice(-1)[0];
                if (lastName.includes(filter)) {
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
                    noResultsMessage.textContent = "No Customers found with this Last Name";
                    document.querySelector("#customerTable").insertAdjacentElement("afterend", noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }
        });
    </script>
</x-app-layout>
