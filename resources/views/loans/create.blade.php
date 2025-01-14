@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Loan Application Form</h1>

    <form method="POST" action="{{ route('loans.store') }}">
        @csrf

        <!-- Loan Details -->
        <div class="mb-4">
            <label for="customer_id" class="block text-sm font-medium">Customer ID</label>
            <input type="number" id="customer_id" name="customer_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium">Loan Amount</label>
            <input type="number" step="0.01" id="amount" name="amount" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>


        <div class="mb-4">
            <label for="interest_rate" class="block text-sm font-medium">Interest Rate (%)</label>
            <input type="number" step="0.01" id="interest_rate" name="interest_rate" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="installment_duration" class="block text-sm font-medium">Installment Duration (days)</label>
            <input type="number" id="installment_duration" name="installment_duration" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="total_installments" class="block text-sm font-medium">Total Installments</label>
            <input type="number" id="total_installments" name="total_installments" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <!-- Guarantors Details -->
        <h2 class="text-lg font-bold mt-6 mb-4">Guarantors</h2>
        <div id="guarantors-container">
            <div class="guarantor-item border p-4 mb-4 rounded-md">
                <h3 class="font-medium flex justify-between items-center">Guarantor 1
                    <button type="button" class="minimize-btn text-sm text-blue-500 ml-2">Minimize</button>
                    <button type="button" class="remove-btn text-sm text-red-500 ml-2">Remove</button>
                </h3>
                <div class="guarantor-details">
                    <div class="mb-4">
                        <label for="guarantors[0][name]" class="block text-sm font-medium">Name</label>
                        <input type="text" name="guarantors[0][name]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][contact]" class="block text-sm font-medium">Contact</label>
                        <input type="text" name="guarantors[0][contact]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][address]" class="block text-sm font-medium">Address</label>
                        <input type="text" name="guarantors[0][address]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][national_id]" class="block text-sm font-medium">National ID</label>
                        <input type="text" name="guarantors[0][national_id]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][relationship]" class="block text-sm font-medium">Relationship</label>
                        <input type="text" name="guarantors[0][relationship]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][date_of_birth]" class="block text-sm font-medium">Date of Birth</label>
                        <input type="date" name="guarantors[0][date_of_birth]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][occupation]" class="block text-sm font-medium">Occupation</label>
                        <input type="text" name="guarantors[0][occupation]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][annual_income]" class="block text-sm font-medium">Annual Income</label>
                        <input type="number" step="0.01" name="guarantors[0][annual_income]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][additional_notes]" class="block text-sm font-medium">Additional Notes</label>
                        <textarea name="guarantors[0][additional_notes]" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="add-guarantor" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Guarantor</button>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Submit Loan Application</button>
        </div>
    </form>
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners for the default guarantor
    const defaultGuarantor = document.querySelector('.guarantor-item');
    const minimizeBtn = defaultGuarantor.querySelector('.minimize-btn');
    const removeBtn = defaultGuarantor.querySelector('.remove-btn');

    minimizeBtn.addEventListener('click', (e) => {
        const details = defaultGuarantor.querySelector('.guarantor-details');
        if (details.style.display === 'none') {
            details.style.display = 'block';
            e.target.innerText = 'Minimize';
        } else {
            details.style.display = 'none';
            e.target.innerText = 'Expand';
        }
    });

    removeBtn.addEventListener('click', () => {
        defaultGuarantor.remove();
    });
});

    let guarantorIndex = 1;
    document.getElementById('add-guarantor').addEventListener('click', () => {
        const container = document.getElementById('guarantors-container');
        const guarantorTemplate = document.createElement('div');
        guarantorTemplate.className = 'guarantor-item border p-4 mb-4 rounded-md';
        guarantorTemplate.innerHTML = `
            <h3 class="font-medium flex justify-between items-center">Guarantor ${guarantorIndex + 1}
                <button type="button" class="minimize-btn text-sm text-blue-500 ml-2">Minimize</button>
                <button type="button" class="remove-btn text-sm text-red-500 ml-2">Remove</button>
            </h3>
            <div class="guarantor-details">
                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][name]" class="block text-sm font-medium">Name</label>
                    <input type="text" name="guarantors[${guarantorIndex}][name]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][contact]" class="block text-sm font-medium">Contact</label>
                    <input type="text" name="guarantors[${guarantorIndex}][contact]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][address]" class="block text-sm font-medium">Address</label>
                    <input type="text" name="guarantors[${guarantorIndex}][address]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][national_id]" class="block text-sm font-medium">National ID</label>
                    <input type="text" name="guarantors[${guarantorIndex}][national_id]" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][relationship]" class="block text-sm font-medium">Relationship</label>
                    <input type="text" name="guarantors[${guarantorIndex}][relationship]" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][date_of_birth]" class="block text-sm font-medium">Date of Birth</label>
                    <input type="date" name="guarantors[${guarantorIndex}][date_of_birth]" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][occupation]" class="block text-sm font-medium">Occupation</label>
                    <input type="text" name="guarantors[${guarantorIndex}][occupation]" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][annual_income]" class="block text-sm font-medium">Annual Income</label>
                    <input type="number" step="0.01" name="guarantors[${guarantorIndex}][annual_income]" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="guarantors[${guarantorIndex}][additional_notes]" class="block text-sm font-medium">Additional Notes</label>
                    <textarea name="guarantors[${guarantorIndex}][additional_notes]" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
                </div>
            </div>
        `;

        guarantorTemplate.querySelector('.remove-btn').addEventListener('click', () => {
            guarantorTemplate.remove();
        });
        guarantorTemplate.querySelector('.minimize-btn').addEventListener('click', (e) => {
            const details = guarantorTemplate.querySelector('.guarantor-details');
            if (details.style.display === 'none') {
                details.style.display = 'block';
                e.target.innerText = 'Minimize';
            } else {
                details.style.display = 'none';
                e.target.innerText = 'Expand';
            }
        });

        container.appendChild(guarantorTemplate);
        guarantorIndex++;
    });
</script>
@endsection
