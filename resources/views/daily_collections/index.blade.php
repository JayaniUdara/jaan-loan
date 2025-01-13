@extends('layouts.app')

@section('content')
<style>
    #notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border-radius: 10px;
        z-index: 9999;
        display: none;
        animation: slideDown 0.5s ease, slideUp 0.5s ease 3s;
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filters label {
        font-weight: bold;
        display: block;
    }

    .filters input,
    .filters select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100%;
    }

    .filters button {
        background: linear-gradient(135deg, #512888, #4b2cf0);
        color: white;
        border: none;
        padding: 10px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 20px;
    }

    .filters button:hover {
        background: linear-gradient(135deg, #4b2cf0, #512888);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    table th, table td {
        text-align: left;
        padding: 12px;
        border: 1px solid #ddd;
    }

    table th {
        background: #f4f4f4;
        font-weight: bold;
    }

    .dataTables_paginate .paginate_button {
        background: linear-gradient(135deg, #2196f3, #1e88e5);
        color: white !important;
        border-radius: 5px;
        margin: 2px;
        padding: 5px 10px;
        border: none;
    }

    .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #1e88e5, #1565c0);
    }

    .custom-print-btn {
        background: linear-gradient(135deg, #2196f3, #1e88e5);
        color: white;
        font-weight: bold;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .custom-print-btn:hover {
        background: linear-gradient(135deg, #1e88e5, #1565c0);
    }
</style>

@if(session('success') || session('error'))
    <div id="notification" class="bg-gradient-to-r from-green-400 to-blue-500">
        {{ session('success') ?? session('error') }}
    </div>
@endif

<div class="bg-white p-6 shadow-md rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daily Collections</h2>
        <a href="{{ route('daily-collections.create.past') }}" class="text-white px-4 py-2 rounded-md" style="background: linear-gradient(135deg, #8A2BE2, #00BFFF);">
            Add Past Record
        </a>
    </div>

    <!-- Filters -->
    <div class="filters">
        <div>
            <label for="filter-date">Date</label>
            <input type="date" id="filter-date" value="{{ now()->toDateString() }}">
        </div>
        <button id="reset-filters">Reset Filters</button>
    </div>

    <!-- Table -->
    <table id="daily-collections-table" class="w-full">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Collection Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collections as $collection)
            <tr>
                <td>{{ $collection->customer->name }}</td>
                <td>{{ $collection->collection_date}}</td>
                <td>LKR {{ number_format($collection->amount_collected, 2) }}</td>
                <td>
                    <span class="{{ $collection->status === 'collected' ? 'text-green-600 font-bold' : 'text-yellow-600 font-bold' }}">
                        {{ ucfirst($collection->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = $('#daily-collections-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'custom-print-btn'
                }
            ]
        });

        $('#filter-date').on('change', function () {
            const selectedDate = $(this).val();
            if (selectedDate) {
                table.column(0).search(selectedDate).draw();
            } else {
                table.column(0).search('').draw(); // Clear the filter when no date is selected
            }
        });

        $('#reset-filters').on('click', function () {
            $('#filter-date').val('');
            table.search('').columns().search('').draw(); // Reset all filters
        });
    });
</script>

@endsection
