<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New customer') }}
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
                    @if (session('error'))
                        <div id="error-message" class="bg-red-500 text-white p-4 rounded-md mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.customers.store') }}" method="POST">
                        @csrf

                        <!-- First Name -->
                        <div class="mb-4">
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">first name</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('first_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">last name</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('last_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                            @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Remarks -->
                        <div class="mb-4">
                            <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300">remarks</label>
                            <textarea id="remarks" name="remarks" rows="4" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">{{ old('remarks') }}</textarea>
                            @error('remarks')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                                Add customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide success message after 3 seconds
        setTimeout(function() {
            const successMessage = document.getElementById("success-message");
            if (successMessage) {
                successMessage.style.display = "none";
            }
        }, 3000);

        // Hide error message after 3 seconds
        setTimeout(function() {
            const errorMessage = document.getElementById("error-message");
            if (errorMessage) {
                errorMessage.style.display = "none";
            }
        }, 3000);
    </script>
</x-app-layout>
