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
    table#customers-table {
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
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
    }

    .filters button:hover {
        background: linear-gradient(135deg, #512888, #4b2cf0);
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
<div class="bg-white p-6 shadow-md rounded">
   
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl font-bold text-[#184E77]">Customers</h2>
 
            <a href="{{ route('customers.create') }}" class="text-white px-4 py-2 rounded-md" style="background: #184E77">
                Add New Customer
            </a>
        </div>

<!-- Filters -->
<div class="filters bg-gray-50 rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-700 ">Filters</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        <!-- Date Filters -->
        <div class="bg-gray-100 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-600">Date</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="filter-date-start" class="block font-medium text-gray-700">Start Date</label>
                    <input type="date" id="filter-date-start" class="w-full border-gray-300 rounded-full p-1 shadow-sm">
                </div>
                <div>
                    <label for="filter-date-end" class="block font-medium text-gray-700">End Date</label>
                    <input type="date" id="filter-date-end" class="w-full border-gray-300 rounded-full p-1 shadow-sm">
                </div>
            </div>
        </div>

        <!-- Monthly Income Filters -->
        <div class="bg-gray-100 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-600">Monthly Income</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="min-income" class="block font-medium text-gray-700">Minimum</label>
                    <input type="number" id="min-income" class="w-full border-gray-300 rounded-full p-1 shadow-sm" placeholder="Min Income">
                </div>
                <div>
                    <label for="max-income" class="block font-medium text-gray-700">Maximum</label>
                    <input type="number" id="max-income" class="w-full border-gray-300 rounded-full p-1 shadow-sm" placeholder="Max Income">
                </div>
            </div>
        </div>

        <!-- Outstanding Balance Filters -->
        <div class="bg-gray-100 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-600">Outstanding Balance</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="min-balance" class="block font-medium text-gray-700">Minimum</label>
                    <input type="number" id="min-balance" class="w-full border-gray-300 rounded-full p-3 shadow-sm" placeholder="Min Balance">
                </div>
                <div>
                    <label for="max-balance" class="block font-medium text-gray-700">Maximum</label>
                    <input type="number" id="max-balance" class="w-full border-gray-300 rounded-full p-3 shadow-sm" placeholder="Max Balance">
                </div>
            </div>
        </div>

</div>
<div class="w-2/3 flex justify-center items-end space-x-4">
    <!-- Status Filter -->
    <div class="w-2/3">
        <label for="filter-status" class="block font-medium text-gray-700">Filter by Status</label>
        <select id="filter-status" class="w-full border-gray-300 rounded-full p-3 shadow-sm">
            <option value="">All</option>
            <option value="Approved">Approved</option>
            <option value="Pending">Pending</option>
        </select>
    </div>
    <div class="w-full">
        <input 
            type="text" 
            id="custom-search-bar" 
            placeholder="Search customers..." 
            class="w-full border-gray-300 rounded-lg p-2 shadow-sm"
        >
    </div>

</div>
           <!-- Buttons -->
           <div class=" w-full flex justify-end gap-4">
            <button id="reset-filters" class="bg-gray-700 text-white px-4 py-3 rounded-full shadow-sm font-bold hover:bg-gray-800">
                Reset Filters
            </button>
            <button id="custom-print" class="text-white px-4 py-2 rounded-lg font-bold shadow-md">
                🖨 Export Records
            </button>
        </div>
</div>


    <!-- Table -->
    <table id="customers-table" class="table-auto w-full text-sm mt-4 border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Contact</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Address</th>
                <th class="border px-4 py-2">Date of Birth</th>
                <th class="border px-4 py-2">National ID</th>
                <th class="border px-4 py-2">Occupation</th>
                <th class="border px-4 py-2">Monthly Income</th>
                <th class="border px-4 py-2">Approved</th>
                <th class="border px-4 py-2">Outstanding Balance</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td class="border px-4 py-2">{{ $customer->name }}</td>
                <td class="border px-4 py-2">{{ $customer->id }}</td>
                <td class="border px-4 py-2">{{ $customer->contact_number }}</td>
                <td class="border px-4 py-2">{{ $customer->email }}</td>
                <td class="border px-4 py-2">{{ $customer->address }}</td>
                <td class="border px-4 py-2">{{ $customer->date_of_birth }}</td>
                <td class="border px-4 py-2">{{ $customer->national_id }}</td>
                <td class="border px-4 py-2">{{ $customer->occupation }}</td>
                <td class="border px-4 py-2">{{ $customer->monthly_income ? 'LKR ' . number_format($customer->monthly_income, 2) : '-' }}</td>
                <td class="border px-4 py-2">
                    @if($customer->is_approved)
                        <span class="text-green-600 font-bold">Approved</span>
                    @else
                        <span class="text-red-600 font-bold">Pending</span>
                        <form action="{{ route('customers.approve', $customer->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded-md">Approve</button>
                        </form>
                    @endif
                </td>
                <td class="border px-4 py-2">
                    LKR {{ number_format($customer->loans->sum('outstanding_balance'), 2) }}
                </td>
                <td class="border px-4 py-2 flex gap-2 justify-center">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-500 hover:underline">✏️ Edit</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">🗑 Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>

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


    $(document).ready(function () {
        const table = $('#customers-table').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom: 'Bfrtip',
            buttons: [
                {
                extend: 'print',
                text: '🖨 Print',
                className: 'hidden-print-btn', // Add custom class
            }
            ], // Add print button
        });


        $('#custom-print').on('click', function () {
        table.button('.buttons-print').trigger();
    });
        // Custom range filtering for Monthly Income and Outstanding Balance
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                const minIncome = parseFloat($('#min-income').val()) || 0;
                const maxIncome = parseFloat($('#max-income').val()) || Number.MAX_VALUE;
                const income = parseFloat(data[7].replace(/[^0-9.-]+/g, '')) || 0;

                const minBalance = parseFloat($('#min-balance').val()) || 0;
                const maxBalance = parseFloat($('#max-balance').val()) || Number.MAX_VALUE;
                const balance = parseFloat(data[9].replace(/[^0-9.-]+/g, '')) || 0;

                const startDate = $('#filter-date-start').val() ? new Date($('#filter-date-start').val()) : null;
                const endDate = $('#filter-date-end').val() ? new Date($('#filter-date-end').val()) : null;
                const dateOfBirth = new Date(data[4]);

                return (
                    income >= minIncome && income <= maxIncome &&
                    balance >= minBalance && balance <= maxBalance &&
                    (!startDate || dateOfBirth >= startDate) &&
                    (!endDate || dateOfBirth <= endDate)
                );
            }
        );

        $('#min-income, #max-income, #min-balance, #max-balance, #filter-date-start, #filter-date-end').on('keyup change', function () {
            table.draw();
        });

        $('#filter-status').on('change', function () {
            const status = $(this).val();
            table.column(8).search(status).draw();
        });

        $('#custom-search-bar').on('keyup', function () {
    table.search(this.value).draw(); // Links custom search to DataTable's default search
});

$('.dataTables_filter').addClass('hidden');


        $('#reset-filters').on('click', function () {
            $('#min-income, #max-income, #min-balance, #max-balance, #filter-date-start, #filter-date-end').val('');
            $('#filter-status').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endsection
