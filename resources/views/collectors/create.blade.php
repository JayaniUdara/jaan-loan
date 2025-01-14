@extends('layouts.app')

@section('content')
<div class="bg-white p-6 shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Add New Collector</h2>
    <form action="{{ route('collectors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="user_id" class="block font-semibold">User ID</label>
            <input type="text" name="user_id" id="user_id" class="w-full border-gray-300 rounded-md p-2" required>
        </div>
        <div class="mb-4">
            <label for="assigned_date" class="block font-semibold">Assigned Date</label>
            <input type="date" name="assigned_date" id="assigned_date" class="w-full border-gray-300 rounded-md p-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Collector</button>
    </form>
</div>
@endsection
