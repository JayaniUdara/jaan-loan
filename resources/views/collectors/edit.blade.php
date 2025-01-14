@extends('layouts.app')

@section('content')
<div class="bg-white p-6 shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Edit Loan Collector</h2>
    <form action="{{ route('collectors.update', $collector->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="user_id" class="block font-semibold">User ID</label>
            <input type="text" name="user_id" id="user_id" value="{{ $collector->user_id }}" class="w-full border-gray-300 rounded-md p-2" required>
        </div>
        <div class="mb-4">
            <label for="assigned_date" class="block font-semibold">Assigned Date</label>
            <input type="date" name="assigned_date" id="assigned_date" value="{{ $collector->assigned_date }}" class="w-full border-gray-300 rounded-md p-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Collector</button>
    </form>
</div>
@endsection
