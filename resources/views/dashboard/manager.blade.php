@extends('layouts.app')

@section('content')
<div class="w-full grid grid-cols-1 md:grid-cols-4 gap-6 md:px-0 px-8">
    <!-- Customer Management -->
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

    <!-- Loan Management -->
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

    <!-- Daily Collections -->
    <div 
        class="p-6 shadow rounded-lg hover:shadow-lg transition cursor-pointer text-white space-y-4 group" 
        onclick="window.location='{{ route('daily-collections.index') }}'"
        style="background: #C62E2E;"
        onmouseout="this.style.background='#C62E2E'; this.style.color='#FFFFFF';"
    >
    <div class="w-full flex justify-center items-center">
        <div class="w-4/6 flex justify-center items-center bg-white rounded-full p-8">
            <img src="./dashboard_images/cash-on-delivery.png" alt="Icon 1" class="w-[130px]">
        </div>
    </div>
    <h2 class="text-xl font-bold roboto- text-center group-hover:text-white">Daily Collections</h2>

        <p class="group-hover:text-white roboto- text-sm  text-center">Monitor and manage daily collection records with ease and accuracy.</p>
    </div>

    <!-- Collectors Management -->
    <div 
        class="p-6 shadow rounded-lg hover:shadow-lg text-white transition space-y-4 cursor-pointer group" 
        onclick="window.location='{{ route('collectors.index') }}'"
        style="background: #914F1E;"
        onmouseout="this.style.background='#914F1E'; this.style.color='#FFFFFF';"
    >
    <div class="w-full flex justify-center items-center">
        <div class="w-4/6 flex justify-center items-center bg-white rounded-full p-8">
            <img src="./dashboard_images/personal.png" alt="Icon 1" class="w-[130px]">
        </div>
    </div>
    <h2 class="text-xl font-bold group-hover:text-white roboto- text-center">Collectors Management</h2>

        <p class="text-center roboto- text-sm  group-hover:text-white">Assign tasks, track progress, and manage loan collectors seamlessly.</p>
    </div>

    <!-- Settings -->
    <div 
        class=" p-6 shadow rounded-lg hover:shadow-lg transition space-y-4 cursor-pointer text-white group" 
        onclick="window.location='{{ route('profile.edit') }}'"
        style="background: #CB9DF0;"
        onmouseout="this.style.background='#CB9DF0'; this.style.color='#FFFFFF';"
    >
    <div class="w-full flex justify-center items-center">
        <div class="w-4/6 flex justify-center items-center bg-white rounded-full p-8">
            <img src="./dashboard_images/user-setting.png" alt="Icon 1" class="w-[130px]">
        </div>
    </div>
    <h2 class="text-xl font-bold roboto- text-center group-hover:text-white">Settings</h2>

        <p class="group-hover:text-white text-sm  roboto- text-center">Customize your application settings and adjust preferences effortlessly.</p>
    </div>

    <!-- Reports -->
    <div 
        class="p-6 shadow rounded-lg hover:shadow-lg transition cursor-pointer space-y-4 text-white group" 
        onclick="window.location='{{ route('reports.index') }}'"
        style="background: #FF8000;"
        onmouseout="this.style.background='#FF8000'; this.style.color='#FFFFFF';"
    >
    <div class="w-full flex justify-center items-center">
        <div class="w-4/6 flex justify-center items-center bg-white rounded-full p-8">
            <img src="./dashboard_images/health-check.png" alt="Icon 1" class="w-[130px]">
        </div>
    </div>
    <h2 class="text-xl nunito-sans- text-center font-bold group-hover:text-white">Reports</h2>

        <p class="roboto- text-sm  text-center group-hover:text-white">Generate detailed reports and insights to support decision-making.</p>
    </div>
</div>
@endsection
