<section class="bg-white w-full">
    <header class="mb-4">
        <h2 class="text-lg font-medium text-[#184E77] text-center">Update Password</h2>
        <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
<div class="w-full flex space-x-4">
    <div class="w-1/3 mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
        <input id="current_password" name="current_password" type="password" class="block w-full mt-1 p-2 border border-gray-300 rounded" autocomplete="current-password" />
        @error('current_password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="w-1/3 mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
        <input id="password" name="password" type="password" class="block w-full mt-1 p-2 border border-gray-300 rounded" autocomplete="new-password" />
        @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="w-1/3 mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1 p-2 border border-gray-300 rounded" autocomplete="new-password" />
        @error('password_confirmation')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

</div>
        
        <div class="flex justify-center">
            <button type="submit" class="bg-[#184E77] px-16 py-1 text-white rounded hover:bg-blue-700">Save</button>
        </div>
    </form>
</section>
