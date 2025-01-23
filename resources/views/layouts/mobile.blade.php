<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Loan Management System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <!-- External JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <style>
        @media (max-width: 768px) {
            .nav-content {
                display: none;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-title {
                text-align: center;
            }

            .menu-button {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }

        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="p-4 text-white sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <!-- Menu Button for Mobile -->
            <div class="menu-button md:hidden">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2"><img src="./dashboard_images/white-logo-removebg-preview (1).png" alt="Icon 1" class="w-[130px]"></a>
                
                <button id="user-menu1" 
                class="flex items-center space-x-2 text-black px-4 py-2 rounded-lg hover:bg-white/10 transition focus:outline-none focus:ring-2 focus:ring-white">
            <div class="flex flex-col md:flex-row md:items-center">
                <span class="font-bold">{{ Auth::user()->name }}</span>
                <span class="text-sm md:ml-2">({{ ucfirst(Auth::user()->role) }})</span>
            </div>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div id="dropdown1" 
                         class="hidden absolute right-0 mt-2 w-48 bg-white text-black shadow-lg rounded-lg overflow-hidden">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                            Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 transition">
                                Logout
                            </button>
                        </form>
                    </div>
            </div>

            <!-- Nav Content Wrapper -->
            <div class="nav-content flex flex-row justify-between items-center gap-4">
                <!-- Left Side - Home Link -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2"><img src="./dashboard_images/white-logo-removebg-preview (1).png" alt="Icon 1" class="w-[130px]"></a>
                </div>

                <!-- Right Side - User Menu -->
                <div class="flex-shrink-0 relative">
                    <!-- User Menu Button -->
                    <button id="user-menu" 
                            class="flex items-center space-x-2 text-black px-4 py-2 rounded-lg hover:bg-white/10 transition focus:outline-none focus:ring-2 focus:ring-white">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <span class="font-bold">{{ Auth::user()->name }}</span>
                            <span class="text-sm md:ml-2">({{ ucfirst(Auth::user()->role) }})</span>
                        </div>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdown" 
                         class="hidden absolute right-0 mt-2 w-48 bg-white text-black shadow-lg rounded-lg overflow-hidden">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                            Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @yield('scripts')

    <!-- JavaScript for Menu Interactions -->
    <script>
        // Toggle user menu

        const menuToggle = document.getElementById('menu-toggle');
        const navContent = document.querySelector('.nav-content');

        userMenu?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        // Script to toggle the dropdown visibility
        document.getElementById('user-menu').addEventListener('click', function () {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close the dropdown when clicking outside
        window.addEventListener('click', function (e) {
            const userMenu = document.getElementById('user-menu');
            const dropdown = document.getElementById('dropdown');
            if (!userMenu.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });


        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                dropdown.classList.add('hidden');
                navContent.classList.add('hidden');
            }
        });
        
    </script>
    <script>
        // Script to toggle the dropdown visibility
        document.getElementById('user-menu1').addEventListener('click', function () {
            const dropdown = document.getElementById('dropdown1');
            dropdown.classList.toggle('hidden');
        });

        // Close the dropdown when clicking outside
        window.addEventListener('click', function (e) {
            const userMenu = document.getElementById('user-menu1');
            const dropdown = document.getElementById('dropdown1');
            if (!userMenu.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
