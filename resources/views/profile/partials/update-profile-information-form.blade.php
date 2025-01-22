<form method="POST" action="{{ route('profile.update') }}" class="bg-white p-6 shadow-md rounded">
    @csrf
    @method('PATCH')

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input id="name" class="block w-full mt-1 p-2 border border-gray-300 rounded" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required />
    </div>

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" class="block w-full mt-1 p-2 border border-gray-300 rounded" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
    </div>
</form>
