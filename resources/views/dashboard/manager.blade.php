
    @extends('layouts.app')

    @section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
            <h2 class="text-xl font-bold">Customer Management</h2>
            <p class="text-gray-600">Manage customer details and view customer lists.</p>
            <a href="{{ route('customers.index') }}" class="text-blue-500 mt-4 block">Go to Customer Management</a>
        </div>
        <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
            <h2 class="text-xl font-bold">Loan Management</h2>
            <p class="text-gray-600">Create, view, and manage loans.</p>
            <a href="{{ route('loans.index') }}" class="text-blue-500 mt-4 block">Go to Loan Management</a>
        </div>
        <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
            <h2 class="text-xl font-bold">Daily Collections</h2>
            <p class="text-gray-600">View and manage daily collections.</p>
            <a href="{{ route('daily-collections.index') }}" class="text-blue-500 mt-4 block">Go to Daily Collections</a>
        </div>
        <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
            <h2 class="text-xl font-bold">Collectors Management</h2>
            <p class="text-gray-600">Manage and assign tasks to loan collectors.</p>
            <a href="{{ route('collectors.index') }}" class="text-blue-500 mt-4 block">Go to Collectors Management</a>
        </div>
        <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
            <h2 class="text-xl font-bold">Settings</h2>
            <p class="text-gray-600">Configure application settings and preferences.</p>
            <a href="{{ route('profile.edit') }}" class="text-blue-500 mt-4 block">Go to Settings</a>
        </div>
        <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
            <h2 class="text-xl font-bold">Reports</h2>
            <p class="text-gray-600">Generate and view reports.</p>
            <a href="{{ route('reports.index') }}" class="text-blue-500 mt-4 block">Go to Reports</a>
        </div>
    </div>

    <script>
        const userMenu = document.getElementById('user-menu');
        const dropdown = document.getElementById('dropdown');
        userMenu.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });
    </script>
@endsection
