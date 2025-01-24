<form method="POST" action="{{ route('profile.update') }}" class="bg-white p-6 shadow-md rounded">
    @csrf
    @method('PATCH')
<div class="w-full flex space-x-4">
    <div class="w-1/2 mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input id="name" class="block w-full mt-1 p-2 border border-gray-300 rounded" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required />
    </div>

    <div class="w-1/2 mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" class="block w-full mt-1 p-2 border border-gray-300 rounded" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
    </div>
</div>

    <div class="flex justify-center">
        <button type="submit" class="px-16 py-1 text-white rounded bg-[#184E77] hover:bg-blue-700">Save</button>
    </div>
</form>
