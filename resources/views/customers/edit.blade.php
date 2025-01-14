@extends('layouts.app')

@section('content')
<div class="bg-white p-6 shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Edit Customer</h2>
    <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-semibold">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="w-full border-gray-300 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label for="contact_number" class="block font-semibold">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $customer->contact_number) }}" class="w-full border-gray-300 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block font-semibold">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <label for="address" class="block font-semibold">Address</label>
            <textarea name="address" id="address" class="w-full border-gray-300 rounded-md p-2">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="date_of_birth" class="block font-semibold">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}" class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <label for="national_id" class="block font-semibold">National ID</label>
            <input type="text" name="national_id" id="national_id" value="{{ old('national_id', $customer->national_id) }}" class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <label for="occupation" class="block font-semibold">Occupation</label>
            <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $customer->occupation) }}" class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <label for="monthly_income" class="block font-semibold">Monthly Income</label>
            <input type="number" name="monthly_income" id="monthly_income" value="{{ old('monthly_income', $customer->monthly_income) }}" class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Current Image</label>
            <div class="mt-2">
                @if($customer->profile_photo_path)
                    <img src="{{ asset('storage/' . $customer->profile_photo_path)}}" alt="Customer Image" class="w-32 h-32 object-cover rounded-md">
                @else
                    <p class="text-gray-500">No image available.</p>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <label for="profile_photo_path" class="block font-semibold">Upload New Image</label>
            <input type="file" name="profile_photo_path" id="profile_photo_path" class="w-full border-gray-300 rounded-md p-2">
            <p class="text-sm text-gray-500 mt-1">Accepted formats: JPEG, PNG. Max size: 2MB.</p>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Customer</button>
    </form>
</div>

@endsection
