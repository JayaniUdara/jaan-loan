@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Reports</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Loans -->
        <div class="bg-white p-6 shadow rounded">
            <canvas id="loansChart"></canvas>
        </div>

        <!-- Total Customers -->
        <div class="bg-white p-6 shadow rounded">
            <canvas id="customersChart"></canvas>
        </div>

        <!-- Total Collectors -->
        <div class="bg-white p-6 shadow rounded">
            <canvas id="collectorsChart"></canvas>
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
                labels: ['Loans'],
                datasets: [{
                    label: 'Total Loans',
                    data: [{{ $totalLoans }}],
                    backgroundColor: ['#4CAF50'],
                }]
            }
        });

        // Customers Chart
        new Chart(document.getElementById('customersChart'), {
            type: 'doughnut',
            data: {
                labels: ['Customers'],
                datasets: [{
                    label: 'Total Customers',
                    data: [{{ $totalCustomers }}],
                    backgroundColor: ['#FF9800'],
                }]
            }
        });

        // Collectors Chart
        new Chart(document.getElementById('collectorsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Collectors'],
                datasets: [{
                    label: 'Total Collectors',
                    data: [{{ $totalCollectors }}],
                    backgroundColor: ['#2196F3'],
                }]
            }
        });
    });
</script>
@endsection
