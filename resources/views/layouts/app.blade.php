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
    <nav class="p-4 text-white" style="background: linear-gradient(135deg, #8A2BE2, #00BFFF);">
        <div class="container mx-auto flex justify-between items-left">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2">Home</a>
            <h1 class="text-xl">Loan Management System</h1>
            
            <!-- User Dropdown -->
            <div class="relative">
                <button id="user-menu" class="focus:outline-none focus:ring-2 focus:ring-white">
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
    <div class="container mx-auto mt-4">
        @yield('content')
    </div>

    
    @yield('scripts') 
</body>
</html>
