<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="{ 'dark': $store.darkMode.on }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Comprehensive Inventory Management System for efficient tracking and management">

    <title>ITE-System | Inventory Management Solution</title>

    <link rel="icon" type="image" href="{{ ('favicon.ico') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #3b82f6, #6366f1);
        }
        .nav-link {
            position: relative;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .nav-link:hover:after {
            width: 100%;
        }
        .hero-gradient {
            background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, rgba(99,102,241,0.1) 100%);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        .dark .feature-card:hover {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);
        }
    </style>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('darkMode', {
            on: localStorage.getItem('theme') === 'dark',
            toggle() {
                this.on = !this.on
                localStorage.setItem('theme', this.on ? 'dark' : 'light')
                document.documentElement.classList.toggle('dark', this.on)
            },
            init() {
                document.documentElement.classList.toggle('dark', this.on)
            }
        })
    })
    </script>
</head>
<body class="bg-white dark:bg-gray-950 font-sans antialiased text-gray-800 dark:text-gray-200 transition-colors duration-300">

    <!-- Navigation -->

    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ ('images/logo.png') }}" alt="Logo" class="h-12 w-12">
                        <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">Inventory-System</span>
                    </div>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="nav-link text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="#features" class="nav-link text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium">Features</a>
                    <a href="#about" class="nav-link text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium">About</a>
                    <a href="#contact" class="nav-link text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium">Contact</a>
                    <button @click="$store.darkMode.toggle()" class="p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
                        <svg x-show="!$store.darkMode.on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-9h-1M4.34 12h-1m15.36 4.36l-.7-.7M6.34 6.34l-.7-.7m12.02 12.02l-.7-.7M6.34 17.66l-.7-.7M12 5a7 7 0 000 14a7 7 0 000-14z" />
                        </svg>
                        <svg x-show="$store.darkMode.on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707 8 8 0 1017.293 13.293z" />
                        </svg>
                    </button>
                    <a href="{{ url('/admin') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Sign in</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Panel -->
        <div class="md:hidden" x-show="mobileOpen" x-transition>
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white dark:bg-gray-900">
                <a href="#home" class="block text-center text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="#features" class="block text-center text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-base font-medium">Features</a>
                <a href="#about" class="block text-center text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="#contact" class="block text-center text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-base font-medium">Contact</a>
                <button @click="$store.darkMode.toggle()" class="w-full text-center px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span x-show="!$store.darkMode.on">Go Dark Mode</span>
                    <span x-show="$store.darkMode.on">Go Light Mode</span>
                </button>
                <a href="{{ url('/admin') }}" class="block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-base font-medium text-center">Sign in</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="gradient-text">Inventory Management</span>
                        <span class="block text-gray-700 dark:text-gray-300">Made Simple & Efficient</span>
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        Power full system inventory tracking, reduce operational costs, and gain real-time insights with our comprehensive solution.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ url('/admin') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-lg font-semibold shadow-md transition-colors flex items-center justify-center gap-2">
                            Get Started
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="#features" class="border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 px-6 py-3 rounded-lg text-lg font-medium transition-colors flex items-center justify-center gap-2">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700">
                        <img src="{{ asset('images/Dashboard_img.png') }}" alt="Dashboard Preview" class="rounded-lg w-full h-auto">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-blue-600 text-white p-4 rounded-lg shadow-lg hidden lg:block">
                        <div class="text-center">
                            <div class="text-2xl font-bold">99.9%</div>
                            <div class="text-sm">Uptime</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Powerful Features</h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-600 dark:text-gray-400">
                    Everything you need to manage your inventory efficiently
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-boxes text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Inventory Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Real-time tracking of all inventory items with detailed product information and stock levels.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Analytics Dashboard</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Comprehensive analytics to help you understand inventory trends and make data-driven decisions.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-user-shield text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Role Management</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Control user access with customizable roles and permissions to ensure secure and organized system usage.
                    </p>
                </div>

                
                <!-- Feature 4 -->
                <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-exchange-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Inventory Loan</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Efficiently manage item loans and returns, track borrowed inventory, and maintain accurate stock levels.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Mobile Friendly</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Access your inventory data from anywhere with our responsive mobile interface.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">About ITE-System</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        ITE-System is a comprehensive inventory management solution designed to help businesses of all sizes streamline their operations, reduce costs, and improve efficiency.
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Our platform combines powerful features with an intuitive interface, making it easy for anyone to manage inventory without extensive training.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-gray-900 dark:text-white">Trusted by businesses worldwide</span> - companies rely on our solution
                            </p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-gray-900 dark:text-white">24/7 Support</span> - Our team is always ready to help you
                            </p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-gray-900 dark:text-white">Continuous updates</span> - We regularly add new features and improvements
                            </p>
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-xl">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Our Team" class="rounded-lg w-full h-auto shadow-md">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-100 text-gray-600 dark:bg-gray-900 dark:text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-2">
                        <img src="{{ ('images/logo.png') }}" alt="Logo" class="h-12 w-12">
                        <span class="ml-2 text-xl font-bold">Inventory-System</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-l mb-1">Developer:</h3>
                        <ul class="space-y-1 mb-2">
                            <li><a class="ml-5 hover:text-gray-950 dark:hover:text-white transition-colors">Chem Indraboth</a></li>
                            <li><a class="ml-5 hover:text-gray-950 dark:hover:text-white transition-colors">Teng Sear</a></li>
                        </ul>
                        <h3 class="font-semibold text-l mb-1">Adviser:</h3>
                        <ul class="space-y-1">
                            <li><a class="ml-5 hover:text-gray-950 dark:hover:text-white transition-colors">Chhim Bunchhun</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="hover:text-gray-950 dark:hover:text-white transition-colors">Home</a></li>
                        <li><a href="#features" class="hover:text-gray-950 dark:hover:text-white transition-colors">Features</a></li>
                        <li><a href="#about" class="hover:text-gray-950 dark:hover:text-white transition-colors">About</a></li>
                        <li><a href="{{ url('/admin') }}" class="hover:text-gray-950 dark:hover:text-white transition-colors">Dashboard Sign in</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact Us</h3>
                    <address class="not-italic">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            <span>Russian Federation Blvd (110)<br>Phnom Penh, 120404</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-phone-alt mr-3"></i>
                            <span>+(855) 12 747871</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>bothchem698@gmail.com</span>
                        </div>
                    </address>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-sm text-center">
                <p>&copy; 2025 ITE-System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>