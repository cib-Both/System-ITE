<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white shadow-xl rounded-2xl p-10 max-w-md w-full text-center space-y-6">
            <!-- Logo -->
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-20 h-20 rounded-full shadow-sm">
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800">
                <br> Welcome to </br> <span class="text-blue-600">System Inventory Management</span>
            </h1>

            <!-- Button -->
            <a href="{{ url('/admin') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-base font-medium px-6 py-3 rounded-lg transition shadow-md">
                Go to Admin
            </a>
        </div>
    </div>
</body>
</html>
