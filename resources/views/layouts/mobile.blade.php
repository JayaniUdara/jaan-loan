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
                flex-direction: column;
                gap: 1rem;
            }
            .nav-title {
                order: -1;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="p-4 text-white sticky top-0 z-50" style="background: linear-gradient(135deg, #8A2BE2, #00BFFF);">
        <div class="container mx-auto px-4">
            <!-- Nav Content Wrapper -->
            <div class="nav-content flex flex-row justify-between items-center gap-4">
                <!-- Left Side - Home Link -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 hover:bg-white/10 rounded-lg transition">
                        <span class="text-lg font-semibold">Home</span>
                    </a>
                </div>

                <!-- Center - Title -->
                <div class="nav-title flex-grow flex justify-center">
                    <h1 class="text-xl md:text-2xl font-bold">Daily Collection Management</h1>
                </div>

                <!-- Right Side - User Menu -->
                <div class="flex-shrink-0 relative">
                    <!-- User Menu Button -->
                    <button id="user-menu" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition focus:outline-none focus:ring-2 focus:ring-white">
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
        const userMenu = document.getElementById('user-menu');
        const dropdown = document.getElementById('dropdown');

        userMenu?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && !userMenu.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>