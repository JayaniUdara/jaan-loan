@extends('layouts.app')

@section('content')

<div class="bg-gray-50 p-8 shadow-lg rounded-lg">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-700">Loan Details</h2>
        <a href="{{ route('loans.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
            ← Back to Loans
        </a>
    </div>

    <!-- Loan Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Loan Basic Details -->
        <div class="p-6 bg-white rounded-lg shadow-sm">
            <h3 class="font-bold text-lg text-gray-600 mb-4">Basic Details</h3>
            <p><span class="font-semibold text-gray-700">Customer:</span> {{ $loan->customer->name }}</p>
            <p><span class="font-semibold text-gray-700">Loan ID:</span> {{ $loan->loan_custom_id }}</p>
            <p><span class="font-semibold text-gray-700">Loan Amount:</span> LKR {{ number_format($loan->amount, 2) }}</p>
            <p><span class="font-semibold text-gray-700">Outstanding Balance:</span> LKR {{ number_format($loan->outstanding_balance, 2) }}</p>
            <p><span class="font-semibold text-gray-700">Interest Rate:</span> {{ number_format($loan->interest_rate, 2) }}%</p>
            <p><span class="font-semibold text-gray-700">Status:</span> 
                <span class="font-bold {{ $loan->is_approved ? 'text-green-600' : 'text-red-600' }}">
                    {{ $loan->is_approved ? 'Approved' : 'Pending' }}
                </span>
            </p>
        </div>

        <!-- Guarantors -->
        <div class="p-6 bg-white rounded-lg shadow-sm">
            <h3 class="font-bold text-lg text-gray-600 mb-4">Guarantors</h3>
            @foreach($loan->guarantors as $guarantor)
                <div class="border rounded-lg p-4 mb-4 bg-gray-50 shadow-sm">
                    <h4 class="font-semibold text-gray-700">{{ $guarantor->name }}</h4>
                    <p><span class="font-medium">Contact:</span> {{ $guarantor->contact }}</p>
                    <p><span class="font-medium">Address:</span> {{ $guarantor->address }}</p>
                    <p><span class="font-medium">National ID:</span> {{ $guarantor->national_id ?? 'N/A' }}</p>
                    <p><span class="font-medium">Relationship:</span> {{ $guarantor->relationship ?? 'N/A' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
