<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Success & Error Messages --}}
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

                    {{-- Global Validation Errors --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Flight Number -->
                        <div class="mb-4">
                            <label for="flight_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Flight Number</label>
                            <select id="flight_number" name="flight_number" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                                @foreach ($trips as $trip)
                                    <option value="{{ $trip->flight_number }}" {{ old('flight_number', $booking->trip->flight_number) == $trip->flight_number ? 'selected' : '' }}>
                                        {{ $trip->flight_number }} - {{ $trip->destination->country }}
                                    </option>
                                @endforeach
                            </select>
                            @error('flight_number')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Seat Number -->
                        <div class="mb-4">
                            <label for="seat_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seat Number</label>
                            <input type="text" id="seat_number" name="seat_number" value="{{ old('seat_number', $booking->seat_number) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('seat_number')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Purchase Date -->
                        <div class="mb-4">
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Date</label>
                            <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $booking->purchase_date) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('purchase_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Purchase Time -->
                        <div class="mb-4">
                            <label for="purchase_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Time</label>
                            <input type="time" id="purchase_time" name="purchase_time" value="{{ old('purchase_time', $booking->purchase_time) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('purchase_time')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Booking Status -->
                        <div class="mb-4">
                            <label for="booking_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Status</label>
                            <select id="booking_status" name="booking_status" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                                <option value="Active" {{ old('booking_status', $booking->booking_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Cancelled" {{ old('booking_status', $booking->booking_status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="Delayed" {{ old('booking_status', $booking->booking_status) == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                                <option value="Inactive" {{ old('booking_status', $booking->booking_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('booking_status')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $booking->price) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('price')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $booking->quantity) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('quantity')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Special Requests -->
                        <div class="mb-4">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requests</label>
                            <textarea id="special_requests" name="special_requests" rows="4" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">{{ old('special_requests', $booking->special_requests) }}</textarea>
                            @error('special_requests')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select id="is_active" name="is_active" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                                <option value="1" {{ old('is_active', $booking->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $booking->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button type="submit" class="px-6 py-2 bg-yellow-600 text-white font-semibold rounded-md shadow-md hover:bg-yellow-700 dark:bg-yellow-500 dark:hover:bg-yellow-600">
                                Update Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide success message after 3 seconds
        setTimeout(() => {
            const successMessage = document.getElementById("success-message");
            if (successMessage) successMessage.style.display = "none";
        }, 3000);

        // Hide error message after 3 seconds
        setTimeout(() => {
            const errorMessage = document.getElementById("error-message");
            if (errorMessage) errorMessage.style.display = "none";
        }, 3000);
    </script>
</x-app-layout>
