@extends('layouts.app')

@section('content')

@if(session('success') || session('error'))
    <div id="notification" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50"
        style="display: none; background-color: {{ session('success') ? '#4caf50' : '#f44336' }};">
        {{ session('success') ?? session('error') }}
    </div>
@endif
<h2 class="text-2xl font-bold mb-4">Daily Collections</h2>
<table class="table-auto w-full text-sm">
    <thead>
        <tr>
            <th class="border px-4 py-2">Customer</th>
            <th class="border px-4 py-2">Amount</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($collections as $loan)
        @php
            $collection = $collections->firstWhere('loan_id', $loan->id);
        @endphp
        <tr>
            <td class="border px-4 py-2">{{ $loan->customer->name }}</td>
            <td class="border px-4 py-2">{{ number_format($loan->amount_collected, 2) }}</td>
            <td class="border px-4 py-2">
                <span class="{{ $loan->status === 'collected' ? 'text-green-500' : 'text-yellow-500' }}">
                    {{ ucfirst($loan->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
 const userMenu = document.getElementById('user-menu');
        const dropdown = document.getElementById('dropdown');
        userMenu.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

</script>
@endsection
