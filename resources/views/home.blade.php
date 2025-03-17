<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TravelEasy - Home</title>

        <!-- Fonts & TailwindCSS -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


        <style>
            body { font-family: 'Figtree', sans-serif; }
            .primary-color { background-color: #0B4A88; }
            .secondary-color { background-color: #24B4E2; }
            .text-primary { color: #0B4A88; }
            .text-secondary { color: #24B4E2; }
        </style>
    </head>
    <body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4 relative">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="#" class="text-xl font-semibold text-primary">TravelEasy</a>
            <div class="hidden md:flex space-x-6 mx-auto">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary">Home</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary">Over Ons</a>
                <a href="{{ route('deals') }}" class="text-gray-700 hover:text-primary">Aanbiedingen</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary">Contact</a>

            </div>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="border border-primary text-primary px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Log in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 secondary-color text-white rounded-md hover:bg-blue-700 transition">Registreren</a>
            </div>
            <!-- Hamburger Menu -->
            <button id="menu-toggle" class="md:hidden text-primary focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-md p-4 absolute w-full top-16 left-0">
            <a href="#" class="block text-gray-700 hover:text-primary py-2">Home</a>
            <a href="#about" class="block text-gray-700 hover:text-primary py-2">Over Ons</a>
            <a href="#deals" class="block text-gray-700 hover:text-primary py-2">Aanbiedingen</a>
            <a href="#contact" class="block text-gray-700 hover:text-primary py-2">Contact</a>
        </div>
    </nav>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    <!-- Hero Section met achtergrondafbeelding en overlay -->
    <header class="relative bg-cover bg-center h-screen flex items-center justify-center text-white text-center" style="background-image: url('{{ asset('img/hero-image.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 container mx-auto">
            <h1 class="text-4xl font-bold">Goedkoop en Snel Jouw Vliegtickets Boeken</h1>
            <p class="mt-4 text-lg">Ontdek de beste deals voor wereldwijde bestemmingen.</p>
            <a href="#deals" class="mt-6 inline-block px-6 py-3 bg-white text-primary font-semibold rounded-md hover:bg-gray-200">Bekijk Aanbiedingen</a>
        </div>
    </header>

    <!-- Waarom TravelEasy? -->
    <section class="py-16 bg-white text-center">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-gray-900">Waarom kiezen voor TravelEasy?</h2>
            <div class="mt-8 grid md:grid-cols-3 gap-6 px-6">
                <div class="bg-gray-100 p-6 rounded-lg shadow">
                    <span class='material-icons text-primary text-5xl mx-auto mb-4'>attach_money</span>
                    <h3 class="text-xl font-semibold text-primary">Beste Prijzen</h3>
                    <p class="mt-2">Wij vergelijken prijzen van honderden luchtvaartmaatschappijen om je de beste deals te bieden.</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg shadow">
                    <span class='material-icons text-primary text-5xl mx-auto mb-4'>support_agent</span>
                    <h3 class="text-xl font-semibold text-primary">24/7 Klantenservice</h3>
                    <p class="mt-2">Ons team staat altijd klaar om je te helpen met vragen of problemen.</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg shadow">
                    <span class='material-icons text-primary text-5xl mx-auto mb-4'>flight_takeoff</span>
                    <h3 class="text-xl font-semibold text-primary">Eenvoudig Boeken</h3>
                    <p class="mt-2">Een gebruiksvriendelijke interface zorgt ervoor dat je jouw vlucht in enkele klikken kunt boeken.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Aanbiedingen Sectie -->
    <section id="deals" class="py-16 bg-gray-100 text-center">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-gray-900">Top Aanbiedingen</h2>
            <div class="mt-8 grid md:grid-cols-3 gap-6 px-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="{{ asset('img/statue-of-liberty.jpg') }}" alt="Aanbieding 1" class="rounded-md mb-4">
                    <h3 class="text-xl font-semibold text-primary">Speciale Deal: Amsterdam - New York</h3>
                    <p class="mt-2">Boek nu en bespaar tot 30% op je vlucht naar New York!</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="{{ asset('img/bali.jpg') }}" alt="Aanbieding 2" class="rounded-md mb-4">
                    <h3 class="text-xl font-semibold text-primary">Zomeraanbieding: Bali</h3>
                    <p class="mt-2">Geniet van een tropische vakantie met kortingen op vliegtickets.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <img src="{{ asset('img/paris.jpg') }}" alt="Aanbieding 3" class="rounded-md mb-4">
                    <h3 class="text-xl font-semibold text-primary">Citytrip: Parijs</h3>
                    <p class="mt-2">Ontdek de lichtstad met de beste deals op vliegtickets.</p>
                </div>
            </div>
            <a href="#" class="mt-6 inline-block px-6 py-3 bg-blue-800 text-white font-semibold rounded-md hover:bg-blue-700 transition mt-8">Bekijk Alle Deals</a>
        </div>
    </section>

    <!-- Meest gestelde vragen -->
    <section id="faq" class="py-16 bg-white text-center">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-gray-900">Meest Gestelde Vragen</h2>
            <div class="mt-8 max-w-2xl mx-auto text-left">
                <details class="bg-gray-100 p-4 rounded-md mb-4">
                    <summary class="font-semibold text-primary cursor-pointer">Hoe kan ik een vlucht annuleren?</summary>
                    <p class="mt-2">Je kunt je vlucht annuleren via je account of door contact op te nemen met onze klantenservice.</p>
                </details>
                <details class="bg-gray-100 p-4 rounded-md mb-4">
                    <summary class="font-semibold text-primary cursor-pointer">Kan ik mijn boeking wijzigen?</summary>
                    <p class="mt-2">Ja, je kunt je boeking wijzigen via onze website of app, afhankelijk van de luchtvaartmaatschappij.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-6 text-center">
        <div class="container mx-auto">
            <p>© 2025 TravelEasy - Alle rechten voorbehouden</p>
            <div class="mt-4">
                <a href="#" class="mx-2 hover:text-secondary">Privacybeleid</a>
                <a href="#" class="mx-2 hover:text-secondary">Algemene Voorwaarden</a>
                <a href="#" class="mx-2 hover:text-secondary">Klantenservice</a>
            </div>
        </div>
    </footer>

    </body>
    </html>
