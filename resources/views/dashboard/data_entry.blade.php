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
</div>

<script>
        const userMenu = document.getElementById('user-menu');
        const dropdown = document.getElementById('dropdown');
        userMenu.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });
    </script>
@endsection