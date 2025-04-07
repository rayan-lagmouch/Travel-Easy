<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Trip') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('trips.update', $trip->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Employee ID -->
                        <div class="mb-4">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                            <input type="number" name="employee_id" id="employee_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('employee_id', $trip->employee_id) }}" required>
                            @error('employee_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departure ID -->
                        <div class="mb-4">
                            <label for="departure_id" class="block text-sm font-medium text-gray-700">Departure Location ID</label>
                            <input type="number" name="departure_id" id="departure_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('departure_id', $trip->departure_id) }}" required>
                            @error('departure_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Destination ID -->
                        <div class="mb-4">
                            <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination Location ID</label>
                            <input type="number" name="destination_id" id="destination_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('destination_id', $trip->destination_id) }}" required>
                            @error('destination_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Flight Number -->
                        <div class="mb-4">
                            <label for="flight_number" class="block text-sm font-medium text-gray-700">Flight Number</label>
                            <input type="text" name="flight_number" id="flight_number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('flight_number', $trip->flight_number) }}" required>
                            @error('flight_number')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departure Date -->
                        <div class="mb-4">
                            <label for="departure_date" class="block text-sm font-medium text-gray-700">Departure Date</label>
                            <input type="date" name="departure_date" id="departure_date" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('departure_date', $trip->departure_date) }}" required>
                            @error('departure_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departure Time -->
                        <div class="mb-4">
                            <label for="departure_time" class="block text-sm font-medium text-gray-700">Departure Time</label>
                            <input type="time" name="departure_time" id="departure_time" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('departure_time', $trip->departure_time) }}" required>
                            @error('departure_time')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Arrival Date -->
                        <div class="mb-4">
                            <label for="arrival_date" class="block text-sm font-medium text-gray-700">Arrival Date</label>
                            <input type="date" name="arrival_date" id="arrival_date" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('arrival_date', $trip->arrival_date) }}" required>
                            @error('arrival_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Arrival Time -->
                        <div class="mb-4">
                            <label for="arrival_time" class="block text-sm font-medium text-gray-700">Arrival Time</label>
                            <input type="time" name="arrival_time" id="arrival_time" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('arrival_time', $trip->arrival_time) }}" required>
                            @error('arrival_time')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trip Status -->
                        <div class="mb-4">
                            <label for="trip_status" class="block text-sm font-medium text-gray-700">Trip Status</label>
                            <input type="text" name="trip_status" id="trip_status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('trip_status', $trip->trip_status) }}" required>
                            @error('trip_status')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea name="remarks" id="remarks" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('remarks', $trip->remarks) }}</textarea>
                            @error('remarks')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <label for="is_active" class="block text-sm font-medium text-gray-700">Active Status</label>
                            <input type="checkbox" name="is_active" id="is_active" class="mt-1" {{ old('is_active', $trip->is_active) ? 'checked' : '' }}>
                            @error('is_active')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Update Trip</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
