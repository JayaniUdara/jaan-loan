@extends('layouts.mobile')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 shadow rounded hover:shadow-lg cursor-pointer transition roboto- text-white" style="background: #C62E2E;" onclick="window.location='{{ route('mobile.index') }}'">
                <div class="w-full flex justify-center items-center">
                    <div class=" flex justify-center items-center bg-white rounded-full p-8">
                        <img src="./dashboard_images/cash-on-delivery.png" alt="Icon 1" class="w-[130px]">
                    </div>
                </div>
                <h2 class="text-xl font-bold text-center">Daily Collections</h2>
                <p class="text-center">View and manage daily collections.</p>
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
