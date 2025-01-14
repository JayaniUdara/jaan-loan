@extends('layouts.app')

@section('content')

@if(session('success') || session('error'))
    <div id="notification" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50"
        style="display: none; background-color: {{ session('success') ? '#4caf50' : '#f44336' }};">
        {{ session('success') ?? session('error') }}
    </div>
@endif 


<div class="bg-white p-6 shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Edit Loan</h2>
    <form action="{{ route('loans.update', $loan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Loan Details -->
        <div>
            <div>
                <div class="mb-4">
                    <label for="customer_id">Customer</label>
                    <input type="text" name="name" id="name" value="{{ $loan->customer->name }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="amount">Loan Amount</label>
                    <input type="number" name="amount" id="amount" value="{{ $loan->amount }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="interest_rate">Interest Rate (%)</label>
                    <input type="number" name="interest_rate" id="interest_rate" value="{{ $loan->interest_rate }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="installment_duration">Installment Duration (months)</label>
                    <input type="number" name="installment_duration" id="installment_duration" value="{{ $loan->installment_duration }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="total_installments">Total Installments</label>
                    <input type="number" name="total_installments" id="total_installments" value="{{ $loan->total_installments }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="remaining_installments">Remaining Installments</label>
                    <input type="number" name="remaining_installments" id="remaining_installments" value="{{ $loan->remaining_installments }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="outstanding_balance">Outstanding Balance</label>
                    <input type="number" name="outstanding_balance" id="outstanding_balance" value="{{ $loan->outstanding_balance }}" class="w-full border-gray-300 rounded-md p-2" required>
                </div>

                <div class="mb-4">
                    <label for="status">Status</label>
                    <select name="status" id="status" required class="w-full border-gray-300 rounded-md p-2">
                        <option value="pending" {{ $loan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $loan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="approved_by">Approved By</label>
                    <select name="approved_by" id="approved_by" class="w-full border-gray-300 rounded-md p-2">
                        <option value="">Select Approver</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $loan->approved_by == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


            </div>
        </div>

        <!-- Guarantors -->
        <div>
            <div class="text-xl font-bold mb-4">Guarantors</div>
            <div class="card-body">
                <div id="guarantors">
                    @foreach($loan->guarantors as $index => $guarantor)
                        <div class="guarantor" data-index="{{ $index }}">
                            <h5 class=" font-bold mb-4">Guarantor {{ $index + 1 }}</h5>
                            <div class="mb-4">
                                <label for="guarantors[{{ $index }}][name]">Name</label>
                                <input type="text" name="guarantors[{{ $index }}][name]" value="{{ $guarantor->name }}" required class="w-full border-gray-300 rounded-md p-2">
                            </div>

                            <div class="mb-4">
                                <label for="guarantors[{{ $index }}][contact]">Contact</label>
                                <input type="text" name="guarantors[{{ $index }}][contact]" value="{{ $guarantor->contact }}" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>

                            <div class="mb-4">
                                <label for="guarantors[{{ $index }}][address]">Address</label>
                                <input type="text" name="guarantors[{{ $index }}][address]" value="{{ $guarantor->address }}" required class="w-full border-gray-300 rounded-md p-2">
                            </div>

                            <div class="mb-4">
                                <label for="guarantors[{{ $index }}][national_id]">National ID</label>
                                <input type="text" name="guarantors[{{ $index }}][national_id]" value="{{ $guarantor->national_id }}" class="w-full border-gray-300 rounded-md p-2">
                            </div>

                            <div class="mb-4">
                                <label for="guarantors[{{ $index }}][relationship]">Relationship</label>
                                <input type="text" name="guarantors[{{ $index }}][relationship]" value="{{ $guarantor->relationship }}" class="w-full border-gray-300 rounded-md p-2">
                            </div>

                            <div class="mb-4">
                                <label for="guarantors[{{ $index }}][date_of_birth]">Date of Birth</label>
                                <input type="date" name="guarantors[{{ $index }}][date_of_birth]" value="{{ $guarantor->date_of_birth }}" class="w-full border-gray-300 rounded-md p-2">
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary" id="addGuarantor">Add Guarantor</button>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Loan</button>
    </form>
</div>

<script>
    document.getElementById('addGuarantor').addEventListener('click', function() {
        const index = document.querySelectorAll('.guarantor').length;
        const template = `
            <div class="guarantor" data-index="${index}">
                <h5 class=" font-bold mb-4">Guarantor ${index + 1}</h5>
                <div class="mb-4">
                    <label for="guarantors[${index}][name]">Name</label>
                    <input type="text" name="guarantors[${index}][name]" required class="w-full border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-4">
                    <label for="guarantors[${index}][contact]">Contact</label>
                    <input type="text" name="guarantors[${index}][contact]" required class="w-full border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-4">
                    <label for="guarantors[${index}][address]">Address</label>
                    <input type="text" name="guarantors[${index}][address]" required class="w-full border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-4">
                    <label for="guarantors[${index}][national_id]">National ID</label>
                    <input type="text" name="guarantors[${index}][national_id]" class="w-full border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-4">
                    <label for="guarantors[${index}][relationship]">Relationship</label>
                    <input type="text" name="guarantors[${index}][relationship]" class="w-full border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-4">
                    <label for="guarantors[${index}][date_of_birth]">Date of Birth</label>
                    <input type="date" name="guarantors[${index}][date_of_birth]" class="w-full border-gray-300 rounded-md p-2">
                </div>
                <hr>
            </div>
        `;
        document.getElementById('guarantors').insertAdjacentHTML('beforeend', template);
    });
</script>
@endsection
