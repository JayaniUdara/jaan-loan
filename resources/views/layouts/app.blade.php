<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Loan Management System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<!-- Include jQuery -->


<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

</head>
<body class="bg-gray-100">
    <nav class="p-4 text-white">
        <div class="container mx-auto flex justify-between items-left">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2"><img src="/dashboard_images/white-logo-removebg-preview (1).png" alt="Icon 1" class="w-[130px]"></a>
            
            
            <!-- User Dropdown -->
            <div class="relative text-black">
                <button id="user-menu" class="focus:outline-none focus:ring-2 focus:ring-white p-2">
                    <span class="font-bold">{{ Auth::user()->name }}</span> ({{ ucfirst(Auth::user()->role) }})
                </button>
                <div id="dropdown" class="hidden absolute right-0 mt-2 bg-white text-black shadow rounded w-48">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2">
                        @csrf
                        <button type="submit" class="text-left w-full hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="w-full md:px-24">
        @yield('content')
    </div>
    <script>
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
    </script>
    
    @yield('scripts') 
</body>
</html>
