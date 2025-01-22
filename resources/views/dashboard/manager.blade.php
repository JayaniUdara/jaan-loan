@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Customer Management -->
    <div 
        class="bg-white p-6 shadow rounded-3xl hover:shadow-lg transition min-h-[250px] cursor-pointer group" 
        onclick="window.location='{{ route('customers.index') }}'"
        style="background: white;"
        onmouseover="this.style.background='linear-gradient(135deg, #8A2BE2, #00BFFF)'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='inherit';"
    >
        <h2 class="text-xl font-bold group-hover:text-white">Customer Management</h2>
        <p class="text-gray-600 group-hover:text-white">Easily manage customer details, track history, and view customer lists to streamline operations.</p>
        <p class="mt-4 text-sm font-medium text-blue-500 group-hover:text-white">Click to explore Customer Management</p>
    </div>

    <!-- Loan Management -->
    <div 
        class="bg-white p-6 shadow rounded-3xl hover:shadow-lg transition min-h-[250px] cursor-pointer group" 
        onclick="window.location='{{ route('loans.index') }}'"
        style="background: white;"
        onmouseover="this.style.background='linear-gradient(135deg, #8A2BE2, #00BFFF)'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='inherit';"
    >
        <h2 class="text-xl font-bold group-hover:text-white">Loan Management</h2>
        <p class="text-gray-600 group-hover:text-white">Create, view, and manage loans efficiently with automated calculations and tracking.</p>
        <p class="mt-4 text-sm font-medium text-blue-500 group-hover:text-white">Click to explore Loan Management</p>
    </div>

    <!-- Daily Collections -->
    <div 
        class="bg-white p-6 shadow rounded-3xl hover:shadow-lg transition min-h-[250px] cursor-pointer group" 
        onclick="window.location='{{ route('daily-collections.index') }}'"
        style="background: white;"
        onmouseover="this.style.background='linear-gradient(135deg, #8A2BE2, #00BFFF)'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='inherit';"
    >
        <h2 class="text-xl font-bold group-hover:text-white">Daily Collections</h2>
        <p class="text-gray-600 group-hover:text-white">Monitor and manage daily collection records with ease and accuracy.</p>
        <p class="mt-4 text-sm font-medium text-blue-500 group-hover:text-white">Click to explore Daily Collections</p>
    </div>

    <!-- Collectors Management -->
    <div 
        class="bg-white p-6 shadow rounded-3xl hover:shadow-lg transition min-h-[250px] cursor-pointer group" 
        onclick="window.location='{{ route('collectors.index') }}'"
        style="background: white;"
        onmouseover="this.style.background='linear-gradient(135deg, #8A2BE2, #00BFFF)'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='inherit';"
    >
        <h2 class="text-xl font-bold group-hover:text-white">Collectors Management</h2>
        <p class="text-gray-600 group-hover:text-white">Assign tasks, track progress, and manage loan collectors seamlessly.</p>
        <p class="mt-4 text-sm font-medium text-blue-500 group-hover:text-white">Click to explore Collectors Management</p>
    </div>

    <!-- Settings -->
    <div 
        class="bg-white p-6 shadow rounded-3xl hover:shadow-lg transition min-h-[250px] cursor-pointer group" 
        onclick="window.location='{{ route('profile.edit') }}'"
        style="background: white;"
        onmouseover="this.style.background='linear-gradient(135deg, #8A2BE2, #00BFFF)'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='inherit';"
    >
        <h2 class="text-xl font-bold group-hover:text-white">Settings</h2>
        <p class="text-gray-600 group-hover:text-white">Customize your application settings and adjust preferences effortlessly.</p>
        <p class="mt-4 text-sm font-medium text-blue-500 group-hover:text-white">Click to explore Settings</p>
    </div>

    <!-- Reports -->
    <div 
        class="bg-white p-6 shadow rounded-3xl hover:shadow-lg transition min-h-[250px] cursor-pointer group" 
        onclick="window.location='{{ route('reports.index') }}'"
        style="background: white;"
        onmouseover="this.style.background='linear-gradient(135deg, #8A2BE2, #00BFFF)'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='inherit';"
    >
        <h2 class="text-xl font-bold group-hover:text-white">Reports</h2>
        <p class="text-gray-600 group-hover:text-white">Generate detailed reports and insights to support decision-making.</p>
        <p class="mt-6 text-sm font-medium text-blue-500 group-hover:text-white">Click to explore Reports</p>
    </div>
</div>
@endsection
