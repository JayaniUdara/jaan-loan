@extends('layouts.mobile')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 shadow rounded hover:shadow-lg transition">
                <h2 class="text-xl font-bold">Daily Collections</h2>
                <p class="text-gray-600">View and manage daily collections.</p>
                <a href="{{ route('mobile.index') }}" class="text-blue-500 mt-4 block">Go to Daily Collections</a>
            </div>
    </div>
        
<script>
const userMenu = document.getElementById('user-menu');
const dropdown = document.getElementById('dropdown');
userMenu.addEventListener('click', () => {
    dropdown.classList.toggle('hidden');
});
</script>
@endsection
