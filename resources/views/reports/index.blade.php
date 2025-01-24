@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-[#184E77] mb-6">Reports</h1>

    <!-- Analytics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 shadow rounded text-center">
            <h2 class="text-xl font-bold">Total Loans</h2>
            <p class="text-3xl text-blue-600">{{ $totalLoans }}</p>
        </div>
        <div class="bg-white p-6 shadow rounded text-center">
            <h2 class="text-xl font-bold">Total Customers</h2>
            <p class="text-3xl text-green-600">{{ $totalCustomers }}</p>
        </div>
        <div class="bg-white p-6 shadow rounded text-center">
            <h2 class="text-xl font-bold">Total Outstanding Loans</h2>
            <p class="text-3xl text-red-600">LKR {{ number_format($totalOutstandingLoans, 2) }}</p>
        </div>
        <div class="bg-white p-6 shadow rounded text-center">
            <h2 class="text-xl font-bold">Total Dues</h2>
            <p class="text-3xl text-orange-600">LKR {{ number_format($totalDues, 2) }}</p>
        </div>
        <div class="bg-white p-6 shadow rounded text-center">
            <h2 class="text-xl font-bold">Total Collections</h2>
            <p class="text-3xl text-purple-600">LKR {{ number_format($totalCollections, 2) }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 shadow rounded">
            <canvas id="loansChart"></canvas>
        </div>
        <div class="bg-white p-6 shadow rounded">
            <canvas id="customersChart"></canvas>
        </div>
        <div class="bg-white p-6 shadow rounded">
            <canvas id="collectionsChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Loans Chart
        new Chart(document.getElementById('loansChart'), {
            type: 'doughnut',
            data: {
                labels: ['Outstanding Loans', 'Dues'],
                datasets: [{
                    data: [{{ $totalOutstandingLoans }}, {{ $totalDues }}],
                    backgroundColor: ['#4CAF50', '#FF9800'],
                }]
            }
        });

        // Customers Chart
        new Chart(document.getElementById('customersChart'), {
            type: 'doughnut',
            data: {
                labels: ['Customers'],
                datasets: [{
                    data: [{{ $totalCustomers }}],
                    backgroundColor: ['#2196F3'],
                }]
            }
        });

        // Collections Chart
        new Chart(document.getElementById('collectionsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Collections'],
                datasets: [{
                    data: [{{ $totalCollections }}],
                    backgroundColor: ['#9C27B0'],
                }]
            }
        });
    });
</script>
@endsection
