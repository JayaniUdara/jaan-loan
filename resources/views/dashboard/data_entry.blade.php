@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:px-0 px-8">
        
        <div 
        class="p-6 shadow rounded-lg hover:shadow-lg transition cursor-pointer text-white hover:text-white space-y-4 group" 
        onclick="window.location='{{ route('customers.index') }}'"
        style="background: #4d7c0f;"
        onmouseout="this.style.background='#4d7c0f'; this.style.color='#FFFFFF';"
        
    >
<div class="w-full flex justify-center items-center">
    <div class="w-4/6 flex justify-center items-center bg-white rounded-full p-8">
        <img src="./dashboard_images/customer.png" alt="Icon 1" class="w-auto h-auto">
        </div>
</div>
<h2 class="text-xl font-bold group-hover:text-white roboto- text-center" style="font-size: 1.25rem;">Customer Management</h2>
        <p class="group-hover:text-white roboto- text-sm text-center">Easily manage customer details, track history to streamline operations.</p>
    </div>
        
    <div 
    class="p-6 shadow rounded-lg text-white hover:shadow-lg transition space-y-4 cursor-pointer group" 
    onclick="window.location='{{ route('loans.index') }}'"
    style="background: #003161;"
    onmouseout="this.style.background='#003161'; this.style.color='#FFFFFF';"
>
<div class="w-full flex justify-center items-center">
    <div class="w-4/6 flex justify-center items-center bg-white rounded-full p-8">
        <img src="./dashboard_images/signing.png" alt="Icon 1" class="w-[130px]">
    </div>
</div>
<h2 class="text-xl font-bold group-hover:text-white roboto- text-center">Loan Management</h2>

    <p class="group-hover:text-white roboto- text-sm  text-center">Create, view, and manage loans efficiently with automated calculations and tracking.</p>
</div>
</div>

<script>
        const userMenu = document.getElementById('user-menu');
        const dropdown = document.getElementById('dropdown');
        userMenu.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });
    </script>
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
@endsection