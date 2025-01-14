@extends('layouts.app')

@section('content')

@if(session('success') || session('error'))
    <div id="notification" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50"
        style="display: none; background-color: {{ session('success') ? '#4caf50' : '#f44336' }};">
        {{ session('success') ?? session('error') }}
    </div>
@endif
<h2 class="text-2xl font-bold mb-4">Collectors Management</h2>
<a href="{{ route('collectors.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Collector</a>

<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Assigned Date</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($collectors as $collector)
        <tr>
        
            <td class="border px-4 py-2">{{ $collector->user->name }}</td>
            <td class="border px-4 py-2">{{ $collector->user->email }}</td>
            <td class="border px-4 py-2">{{ $collector->assigned_date }}</td>
            <td class="border px-4 py-2">
                <a href="{{ route('collectors.edit', $collector->id) }}" class="text-yellow-500 mx-2">Edit</a>
                <form action="{{ route('collectors.destroy', $collector->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500" onclick="return confirm('Are you sure you want to delete this collector?')">Delete</button>
                </form>
            </td>
        
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
