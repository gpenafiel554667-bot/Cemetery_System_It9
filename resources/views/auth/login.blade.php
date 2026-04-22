<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cemetery Management System - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center">

    <div class="w-full flex min-h-screen">

        <!-- Left Side -->
        <div class="hidden md:flex w-1/2 bg-gray-900 flex-col justify-center p-12 relative overflow-hidden">

            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-full h-full" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10">

                <!-- Logo -->
                <div class="mb-16">
                    <h1 class="text-white text-xl font-bold tracking-wide">Cemetery Management System</h1>
                    <p class="text-gray-500 text-sm mt-1">Authorized Personnel Only</p>
                </div>

                <!-- Quote -->
                <div class="mb-16">
                    <div class="w-12 h-0.5 bg-gray-600 mb-6"></div>
                    <p class="text-gray-300 text-2xl font-light leading-relaxed">
                        "Honoring lives,<br>preserving memories,<br>serving families."
                    </p>
                    <div class="w-12 h-0.5 bg-gray-600 mt-6"></div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mb-16">
                    <div class="bg-gray-800 bg-opacity-50 rounded-xl p-4">
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-2">Established</p>
                        <p class="text-white text-lg font-bold">2000</p>
                    </div>
                    <div class="bg-gray-800 bg-opacity-50 rounded-xl p-4">
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-2">Families</p>
                        <p class="text-white text-lg font-bold">1,200+</p>
                    </div>
                    <div class="bg-gray-800 bg-opacity-50 rounded-xl p-4">
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-2">Lots</p>
                        <p class="text-white text-lg font-bold">500+</p>
                    </div>
                </div>

                <!-- Bottom Info -->
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-800">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-1">Location</p>
                        <p class="text-gray-300 text-sm">Davao City, PH</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-1">Hours</p>
                        <p class="text-gray-300 text-sm">Mon - Sat</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-widest mb-1">Contact</p>
                        <p class="text-gray-300 text-sm">(082) 123-4567</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-gray-950">
            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="md:hidden text-center mb-8">
                    <h1 class="text-white text-xl font-bold">Cemetery Management System</h1>
                    <p class="text-gray-500 text-sm mt-1">Authorized Personnel Only</p>
                </div>

                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-white text-3xl font-bold">Sign In</h2>
                    <p class="text-gray-500 text-sm mt-2">Enter your credentials to access the system.</p>
                </div>

                <!-- Alerts -->
                @if(session('status'))
                    <div class="mb-6 text-sm text-green-400 bg-green-900 bg-opacity-30 border border-green-800 rounded-lg px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 text-sm text-red-400 bg-red-900 bg-opacity-30 border border-red-800 rounded-lg px-4 py-3">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="" required autofocus
                            autocomplete="off"
                            class="w-full bg-gray-900 border border-gray-800 text-white rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent placeholder-gray-600 transition"
                            placeholder="Enter your email address">
                        @error('email')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" required
                                autocomplete="new-password"
                                class="w-full bg-gray-900 border border-gray-800 text-white rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent placeholder-gray-600 transition"
                                style="padding-right: 48px;"
                                placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()"
                                style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                                <svg id="eye-icon" style="width: 20px; height: 20px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-off-icon" style="width: 20px; height: 20px; color: #6b7280; display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-700 bg-gray-900 text-gray-400">
                            <span class="text-sm text-gray-400">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-gray-400 hover:text-white transition">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full bg-white text-gray-900 font-bold py-3.5 rounded-lg hover:bg-gray-200 transition text-sm tracking-wide">
                        Sign In
                    </button>
                </form>

               <!-- Footer -->
<div class="text-center mt-8 space-y-2">
    <a href="{{ route('home') }}" class="block text-gray-400 text-sm hover:text-white transition">
        Back to Home
    </a>
    <p class="text-gray-600 text-xs">
        Cemetery Management System &copy; {{ date('Y') }}. All rights reserved.
    </p>
</div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                input.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }

        window.onload = function() {
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
        }
    </script>

</body>
</html>