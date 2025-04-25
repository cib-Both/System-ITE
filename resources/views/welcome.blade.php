<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ITE-system</title>

    <link rel="icon" type="image" href="{{ asset('favicon.ico') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-900 font-sans antialiased text-gray-800 dark:text-gray-100 transition-colors duration-300">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl p-12 sm:p-16 max-w-2xl w-full text-center space-y-10">
            <!-- Logo -->
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto w-28 h-28 rounded-full shadow-xl dark:bg-white">
            </div>

            <!-- Title -->
            <h1 class="text-4xl font-bold leading-tight">
                Welcome to<br>
                <span class="text-blue-600 dark:text-blue-400">Inventory System Management</span>
            </h1>

            <!-- Button -->
            <a href="{{ url('/admin') }}"
               class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold text-xl px-8 py-4 rounded-xl shadow-lg transition">
               Dashboard
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
               </svg>
            </a>
        </div>
    </div>
</body>
</html>
