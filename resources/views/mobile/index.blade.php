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
    <h2 class="text-2xl font-bold mb-4 text-[#184E77]">Daily Collections</h2>
    <div class="w-full overflow-x-auto">
        <table class="table-auto w-full text-sm">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Customer</th>
                    <th class="border px-4 py-2">Amount Due</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($collections as $collection)
                <tr>
                    <td class="border px-4 py-2">{{ $collection->customer->name }}</td>
                    <td class="border px-4 py-2">{{ number_format($collection->amount_collected, 2) }}</td>
                    <td class="border px-4 py-2">
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
    // Show notification if exists
    const notification = document.getElementById('notification');
    if (notification) {
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }
</script>
@endsection