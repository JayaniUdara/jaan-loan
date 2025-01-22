@extends('layouts.app') <!-- Reference your custom layout -->

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
       
        font-weight: bold;
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
        background: linear-gradient(135deg, #8A2BE2, #00BFFF);
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

@if(session('success') || session('error')|| session('status'))
    <div id="notification" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50"
        style="display: none; background-color: {{ session('success') ? '#4caf50' : '#f44336' }};">
        {{ session('success') ?? session('error') ?? session('status') }}
    </div>
@endif
<div class="py-12 flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-5xl space-y-6">
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="max-w-2xl mx-auto">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow rounded-lg">
            <div class="max-w-2xl mx-auto">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow rounded-lg">
            <div class="max-w-2xl mx-auto">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
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
        
</script>        

@endsection
