@extends('layouts.mobile')

@section('content')
<div class="container mx-auto px-4">
    @if(session('success') || session('error'))
        <div id="notification" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50"
            style="display: none; background-color: {{ session('success') ? '#4caf50' : '#f44336' }};">
            {{ session('success') ?? session('error') }}
        </div>
    @endif
    <div class="w-full">
        <h2 class="text-2xl font-bold mb-4 text-[#184E77] text-center">Daily Collections</h2>
                <!-- Mobile Friendly Card for Total Collected -->
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Total Collected</h3>
                    <p class="text-2xl font-bold">LKR {{ number_format($collections->where('status', 'collected')->sum('amount_collected'), 2) }}</p>
                </div>
        <div class="mb-4 flex flex-col sm:flex-row justify-center gap-2">
            <input type="text" id="custom-search-bar" placeholder="Search records..." class="border rounded p-2 w-full sm:w-auto text-center">

            <select id="status-filter" class="border rounded p-2 w-full sm:w-auto">
                <option value="">All</option>
                <option value="collected">Collected</option>
                <option value="pending">Pending</option>
            </select>
        </div>
        <div class="w-full overflow-x-auto">
            <table id="collections-table" class="table-auto w-full text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Customer</th>
                        <th class="border px-4 py-2">Loan ID</th>
                        <th class="border px-4 py-2">Amount Due</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($collections as $collection)
                    <tr class="text-center">
                        <td class="border px-4 py-2 break-words">{{ $collection->customer->name }}</td>
                        <td class="border px-4 py-2 break-words">{{ $collection->loan->loan_custom_id }}</td>
                        <td class="border px-4 py-2 break-words">{{ number_format($collection->amount_collected, 2) }}</td>
                        <td class="border px-4 py-2 break-words">
                            <span class="{{ $collection->status === 'collected' ? 'text-green-500' : 'text-yellow-500' }}">
                                {{ ucfirst($collection->status) }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('mobile.store') }}" method="POST" class="space-y-2">
                                @csrf
                                <input type="hidden" name="loan_id" value="{{ $collection->loan_id }}">
                                <div class="flex flex-col gap-2">
                                    <select name="status" class="border rounded p-2 w-full">
                                        <option value="collected" {{ $collection->status === 'collected' ? 'selected' : '' }}>Collected</option>
                                        <option value="pending" {{ $collection->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                    <input type="number" 
                                        name="amount_collected"
                                        step="0.01"
                                        class="border rounded p-2 w-full"
                                        placeholder="Amount Collected"
                                        value="{{ $collection->amount_collected ?? $collection->loan->calculated_amount }}">
                                    <textarea
                                        name="notes"
                                        class="border rounded p-2 w-full"
                                        placeholder="Additional Notes">{{ $collection->notes }}</textarea>
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded w-full">
                                        Update Collection
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const table = $('#collections-table').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[1, 'asc']],
            dom: 'lrtip' // Hides default search bar
        });

        $('#custom-search-bar').on('keyup', function () {
            table.search(this.value).draw();
        });

        $('#status-filter').on('change', function () {
            let filterValue = this.value;
            if (filterValue) {
                table.column(3).search(filterValue).draw();
            } else {
                table.column(3).search('').draw();
            }
        });
    });


</script>
@endsection