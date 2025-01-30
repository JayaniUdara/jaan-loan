@extends('layouts.app')

@section('content')
<style>
    @keyframes slideDown {
        from {
            transform: translate(-50%, -100%);
            opacity: 0;
        }
        to {
            transform: translate(-50%, 0%);
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translate(-50%, 0%);
            opacity: 1;
        }
        to {
            transform: translate(-50%, -100%);
            opacity: 0;
        }
    }

    #notification {
        min-width: 300px;
        text-align: center;
        padding: 15px;
        border-radius: 15px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        display: none;
        background: linear-gradient(135deg, #4b2cf0, #f51681); /* Gradient background */
        animation: slideDown 0.5s ease, slideUp 0.5s ease 3s;
    }

    /* Rounded Table Styling */
    table#daily-collections-table {
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    table#customers-table th,
    table#customers-table td {
        border: none;
        padding: 12px 15px;
        text-align: left;
    }

    table#customers-table th {
    background: linear-gradient(135deg, #f9f9f9, #eaeaea); /* Subtle gradient background */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Small shadow for depth */
    padding: 12px 15px;
    text-align: left;
    font-weight: bold;
    color: #333; /* Adjust text color for better readability */
    border-bottom: 2px solid #d1d5db; /* Add a border to separate header */
}

    table#customers-table tbody tr:nth-child(even) {
        background: #f9f9f9;
    }

    table#customers-table tbody tr:nth-child(odd) {
        background: white;
    }

    table#customers-table tbody tr:hover {
        background: #f1f1f1;
        cursor: pointer;
    }

    /* Filters Styling */
    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        background: #f9f9f9;
        padding: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .filters label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .filters input,
    .filters select {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
    }

    .filters button {
        background: #52B69A;
        color: white;
        margin-top:30px;
        height:50%;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
    }

    .filters button:hover {
        background: #52B69A;
    }

    /* Pagination Styling */
    .dataTables_paginate .paginate_button {
       
        color: white !important;
        border-radius: 10px;
        margin: 2px;
        padding: 5px 10px;
        border: none;
    }

    .dataTables_paginate .paginate_button:hover {
      
        color: white !important;
    }

    .dataTables_paginate .paginate_button.current {
      
        color: white !important;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before {
        content: none !important;
    }

    /* Custom Print Button Styling */
.custom-print-btn {
    background: linear-gradient(135deg, #8A2BE2, #00BFFF);
    color: white !important;
    font-weight: bold;
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    
}

.custom-print-btn:hover {
    background: linear-gradient(135deg, #512888, #4b2cf0);
}


    table#customers-table tbody tr {
    border-bottom: 1px solid #e0e0e0;
}

.hidden-print-btn {
    display: none !important; /* Hide the default button */
}
</style>

@if(session('success') || session('error'))
    <div id="notification" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50"
        style="display: none; background-color: {{ session('success') ? '#4caf50' : '#f44336' }};">
        {{ session('success') ?? session('error') }}
    </div>
@endif
<!-- Summary Cards -->



<div class="w-full bg-white p-6 shadow-md rounded">
    <div class="flex md:flex-row flex-col justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daily Collections</h2>

        <div class="w-full flex justify-center space-x-4 mb-4">
            <!-- Total Collected Today --> <h3 class="text-sm font-medium">Today's Summary</h3>
            <div class="summary-card flex items-center justify-between bg-gray-100 shadow-md p-2 w-56">
               
                <div>
                    <h3 class="text-sm font-medium">Total Collected</h3>
                    <p class="text-lg font-semibold">LKR {{ number_format($totalCollected, 2) }}</p>
                </div>
                <div class="text-xl">
                    💰
                </div>
            </div>
            <!-- Total Pending Today -->
            <div class="summary-card flex items-center justify-between bg-gray-100 shadow-md p-2 w-56">
                <div>
                    <h3 class="text-sm font-medium">Total Pending</h3>
                    <p class="text-lg font-semibold">LKR {{ number_format($totalPending, 2) }}</p>
                </div>
                <div class="text-xl">
                    ⏳
                </div>
            </div>
        </div>
        <a href="{{ route('daily-collections.create.past') }}" class="text-white px-4 py-2 rounded-md" style="background: #184E77">
            Add Past Record
        </a>
    </div>
    
<!-- Approve Button -->
<!-- Approve Button -->
@if($collections->where('collection_date', now()->toDateString())->where('is_approved', '!=', 1)->isNotEmpty())
    <form action="{{ route('daily_collections.approve') }}" method="POST">
        @csrf
        <input type="hidden" name="approved_by" value="{{ auth()->id() }}">
        <div class="flex justify-between items-center mb-4">
            <button type="submit" class="text-white px-4 py-2 rounded-md" style="background: linear-gradient(135deg, #8A2BE2, #00BFFF);">
                Approve Today's Records
            </button>
        </div>
    </form>
@else
    <div class="text-green-600 font-bold">All records for today are already approved.</div>
@endif

    <!-- Filters -->
    <div class="filters">
        <div>
            <label for="filter-date">Date</label>
            <input type="date" id="filter-date" value="{{ now()->toDateString() }}">
        </div>
        <button id="reset-filters">Reset Filters</button>
        <button id="custom-print-button" class="custom-print-btn">
            Custom Print
        </button>
    </div>
<div class="w-full overflow-x-auto">
<!-- Table -->
<table id="daily-collections-table" class="w-full">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Loan ID</th>
            <th>Collection Date</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($collections as $collection)
        <tr>
            <td>{{ $collection->customer->name }}</td>
            <td>{{ $collection->loan->loan_custom_id ?? 'N/A'}}</td>
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
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = $('#daily-collections-table').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'custom-print-btn'
                }
            ]
        });


     // Default filter for today's records
        const today = "{{ now()->toDateString() }}";
        table.search(today).draw();

        $('#filter-date').on('change', function () {
            const selectedDate = $(this).val();
            if (selectedDate) {
                table.search(selectedDate).draw();
            } else {
                table.search('').draw(); // Clear the filter when no date is selected
            }
        });

        $('#custom-print-button').on('click', function () {
        table.button('.buttons-print').trigger(); // Trigger the DataTables print button
    });

        $('#reset-filters').on('click', function () {
            $('#filter-date').val('');
            table.search('').columns().search('').draw(); // Reset all filters
        });
    });

    
document.addEventListener('DOMContentLoaded', function () {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'block';
            notification.style.animation = 'slideDown 0.5s ease, slideUp 0.5s ease 3s';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3500); // 3.5 seconds (time for animation + display)
        }
    });
</script>

@endsection
