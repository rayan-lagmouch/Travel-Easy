<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Manage Messages
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Browse and check all Messages saved in the system
                    </p>
                    <a href="{{ route('communications.index') }}" class="text-blue-500 hover:underline">
                        View all Messages &rarr;
                    </a>
                </div>

                <!-- Second Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Manage Invoices
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Browse and check all Invoices made in the system
                    </p>
                    <a href="{{ route('invoices.index') }}" class="text-blue-500 hover:underline">
                        View all Invoices &rarr;
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Manage Bookings
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Browse and check all Booked bookings in the system
                    </p>
                    <a href="{{ route('employee.bookings.index') }}" class="text-blue-500 hover:underline">
                        View all bookings &rarr;
                    </a>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
