@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Daily Collection Form</h1>

    <form method="POST" action="{{ route('daily_collections.storePast') }}">
        @csrf

        <!-- Loan ID -->
        <div class="mb-4">
            <label for="loan_id" class="block text-sm font-medium">Select Loan ID</label>
            <select id="loan_id" name="loan_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="">Select Loan</option>
                @foreach($loans as $loan)
                    <option value="{{ $loan->id }}">Loan ID: {{ $loan->loan_custom_id }} - Amount: {{ $loan->amount }}</option>
                @endforeach
            </select>
        </div>

        <!-- Customer ID -->
        <div class="mb-4">
            <label for="customer_id" class="block text-sm font-medium">Select Customer ID</label>
            <select id="customer_id" name="customer_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Amount Collected -->
        <div class="mb-4">
            <label for="amount_collected" class="block text-sm font-medium">Amount Collected</label>
            <input 
                type="number" 
                step="0.01" 
                id="amount_collected" 
                name="amount_collected" 
                class="mt-1 block w-full border-gray-300 rounded-md" 
                placeholder="Enter amount collected" 
                required>
        </div>

        <!-- Collection Date -->
        <div class="mb-4">
            <label for="collection_date" class="block text-sm font-medium">Collection Date</label>
            <input 
                type="date" 
                id="collection_date" 
                name="collection_date" 
                class="mt-1 block w-full border-gray-300 rounded-md" 
                required>
        </div>
        <!-- Collection Status -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium">Status</label>
            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="collected">Collected</option>
                <option value="pending">Pending</option>
            </select>
        </div>
        <!-- Installment Number -->
        <div class="mb-4">
            <label for="installment_number" class="block text-sm font-medium">Installment Number</label>
            <input 
                type="number" 
                id="installment_number" 
                name="installment_number" 
                class="mt-1 block w-full border-gray-300 rounded-md" 
                placeholder="Enter installment number" 
                required>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Submit Collection</button>
        </div>
    </form>
</div>

@endsection
