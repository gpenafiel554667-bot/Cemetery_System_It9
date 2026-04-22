<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cemetery Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <!-- Navbar -->
    <nav class="bg-gray-950 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide text-white">Cemetery Management System</a>
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm text-gray-300 hover:text-white transition">Home</a>
                <a href="{{ route('public.search') }}" class="text-sm text-gray-300 hover:text-white transition">Search</a>
                <a href="{{ route('public.lots') }}" class="text-sm text-gray-300 hover:text-white transition">Available Lots</a>
                <a href="{{ route('public.services') }}" class="text-sm text-gray-300 hover:text-white transition">Services</a>
                <a href="{{ route('public.contact') }}" class="text-sm text-gray-300 hover:text-white transition">Contact</a>
                <a href="{{ route('login') }}" class="bg-white text-gray-900 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Login</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 text-white mt-16 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-lg mb-3">Cemetery Management System</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Providing dignified and compassionate burial services to families in their time of need.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.search') }}" class="text-gray-400 text-sm hover:text-white transition">Search Records</a></li>
                        <li><a href="{{ route('public.lots') }}" class="text-gray-400 text-sm hover:text-white transition">Available Lots</a></li>
                        <li><a href="{{ route('public.services') }}" class="text-gray-400 text-sm hover:text-white transition">Services</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-gray-400 text-sm hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3">Contact Information</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400 text-sm">Cemetery Road, Davao City</li>
                        <li class="text-gray-400 text-sm">(082) 123-4567</li>
                        <li class="text-gray-400 text-sm">info@cemetery.com</li>
                        <li class="text-gray-400 text-sm">Mon - Sat: 8:00 AM - 5:00 PM</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center">
                <p class="text-gray-500 text-sm">© {{ date('Y') }} Cemetery Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>