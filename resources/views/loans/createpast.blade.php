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

    <form method="POST" action="{{ route('loans.store.past') }}">
        @csrf

        <!-- Loan Details -->
              <!-- Loan Custom ID -->
              <div class="mb-4">
                <label for="loan_custom_id" class="block text-sm font-medium">Loan Custom ID</label>
                <input 
                    type="text" 
                    id="loan_custom_id" 
                    name="loan_custom_id" 
                    class="mt-1 block w-full border-gray-300 rounded-md" 
                    placeholder="Enter a unique loan ID" 
                >
            </div>
 <!-- Customer ID -->
            <div class="mb-4">
                <label for="customer_id" class="block text-sm font-medium">Customer ID</label>
           

                <select id="customer_id" name="customer_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
   <!-- Loan Amount -->
   <div class="mb-4">
    <label for="amount" class="block text-sm font-medium">Loan Amount</label>
    <input type="number" step="0.01" id="amount" name="amount" class="mt-1 block w-full border-gray-300 rounded-md" required>
</div>

<!-- Total with Interest -->
<div class="mb-4">
    <label for="total_with_interest" class="block text-sm font-medium">Total with Interest (2 Months at 10% per month)</label>
    <input 
        type="text" 
        id="total_with_interest" 
        name="total_with_interest" 
        class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100" 
        readonly>
</div>

<!-- Installment Duration -->
<div class="mb-4">
    <label for="installment_duration" class="block text-sm font-medium">Installment Duration</label>
    <select id="installment_duration" name="installment_duration" class="mt-1 block w-full border-gray-300 rounded-md" required>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
    </select>
</div>

<!-- Installment Amount -->
<div class="mb-4">
    <label for="installment_amount" class="block text-sm font-medium">Installment Amount</label>
    <input 
        type="text" 
        id="installment_amount" 
        name="installment_amount" 
        class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100" 
        readonly>
</div>

   <!-- remaining_installments Amount -->
   <div class="mb-4">
    <label for="remaining_installments" class="block text-sm font-medium">Remianing instalments (Number of remaining installments)</label>
    <input type="number" step="0.01" id="remaining_installments" name="remaining_installments" class="mt-1 block w-full border-gray-300 rounded-md" required>
</div>

   <!-- remaining_installments Amount -->
   <div class="mb-4">
    <label for="outstanding_balance" class="block text-sm font-medium">Remaining balance</label>
    <input type="number" step="0.01" id="outstanding_balance" name="outstanding_balance" class="mt-1 block w-full border-gray-300 rounded-md" required>
</div>
       <!-- Loan Approved Date -->
       <div class="mb-4">
        <label for="loan_approved_date" class="block text-sm font-medium">Loan Approved Date</label>
        <input 
            type="date" 
            id="loan_approved_date" 
            name="loan_approved_date" 
            class="mt-1 block w-full border-gray-300 rounded-md">
    </div>

    <!-- Loan End Date -->
    <div class="mb-4">
        <label for="loan_end_date" class="block text-sm font-medium">Loan End Date</label>
        <input 
            type="date" 
            id="loan_end_date" 
            name="loan_end_date" 
            class="mt-1 block w-full border-gray-300 rounded-md">
    </div>

    <!-- Approved By -->

     <div class="mb-4">
        <label for="approved_by" class="block text-sm font-medium">Approved User ID</label>
   

        <select id="approved_by" name="approved_by" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }}</option>
            @endforeach
        </select>
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
                        <label for="guarantors[0][national_id]" class="block text-sm font-medium">National ID</label>
                        <select name="guarantors[0][national_id]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">Select NIC</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->national_id }}">{{ $customer->national_id }} {{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
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

    const amountInput = document.getElementById('amount');
        const totalWithInterestInput = document.getElementById('total_with_interest');
        const installmentDurationSelect = document.getElementById('installment_duration');
        const installmentAmountInput = document.getElementById('installment_amount');

        const calculateTotalWithInterest = (amount) => {
            const interestRate = 0.10; // 10% per month
            const months = 2; // 2 months
            return amount + (amount * interestRate * months);
        };

        const calculateInstallmentAmount = (total, duration) => {
            if (duration === 'daily') {
                return total / 60; // 60 days
            } else if (duration === 'weekly') {
                return total / 8; // 8 weeks
            }
            return 0;
        };

        amountInput.addEventListener('input', () => {
            const amount = parseFloat(amountInput.value) || 0;
            const totalWithInterest = calculateTotalWithInterest(amount);
            totalWithInterestInput.value = totalWithInterest.toFixed(2);

            // Update installment amount based on selected duration
            const duration = installmentDurationSelect.value;
            const installmentAmount = calculateInstallmentAmount(totalWithInterest, duration);
            installmentAmountInput.value = installmentAmount.toFixed(2);
        });

        installmentDurationSelect.addEventListener('change', () => {
            const totalWithInterest = parseFloat(totalWithInterestInput.value) || 0;
            const duration = installmentDurationSelect.value;
            const installmentAmount = calculateInstallmentAmount(totalWithInterest, duration);
            installmentAmountInput.value = installmentAmount.toFixed(2);
        });




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

</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
      const customers = @json($customers);
      const amountInput = document.getElementById('amount');
      const totalWithInterestInput = document.getElementById('total_with_interest');
      const installmentDurationSelect = document.getElementById('installment_duration');
      const installmentAmountInput = document.getElementById('installment_amount');
  
      // Interest calculation functions
      const calculateTotalWithInterest = (amount) => {
          const interestRate = 0.10;
          const months = 2;
          return amount + (amount * interestRate * months);
      };
  
      const calculateInstallmentAmount = (total, duration) => {
          if (duration === 'daily') {
              return total / 60;
          } else if (duration === 'weekly') {
              return total / 8;
          }
          return 0;
      };
  
      // Interest calculation event listeners
      amountInput.addEventListener('input', () => {
          const amount = parseFloat(amountInput.value) || 0;
          const totalWithInterest = calculateTotalWithInterest(amount);
          totalWithInterestInput.value = totalWithInterest.toFixed(2);
  
          const duration = installmentDurationSelect.value;
          const installmentAmount = calculateInstallmentAmount(totalWithInterest, duration);
          installmentAmountInput.value = installmentAmount.toFixed(2);
      });
  
      installmentDurationSelect.addEventListener('change', () => {
          const totalWithInterest = parseFloat(totalWithInterestInput.value) || 0;
          const duration = installmentDurationSelect.value;
          const installmentAmount = calculateInstallmentAmount(totalWithInterest, duration);
          installmentAmountInput.value = installmentAmount.toFixed(2);
      });
  
      // Guarantor functions
      const initializeGuarantorListeners = (guarantorItem) => {
          const nicSelect = guarantorItem.querySelector('select[name$="[national_id]"]');
          if (!nicSelect) return;
  
          nicSelect.addEventListener('change', (e) => {
              const selectedNIC = e.target.value;
              const customer = customers.find(c => c.national_id === selectedNIC);
              
              if (customer) {
                  const guarantorDiv = e.target.closest('.guarantor-item');
                  
                  // Update all fields within this specific guarantor div
                  const nameInput = guarantorDiv.querySelector('input[name$="[name]"]');
                  const contactInput = guarantorDiv.querySelector('input[name$="[contact]"]');
                  const addressInput = guarantorDiv.querySelector('input[name$="[address]"]');
                  const dobInput = guarantorDiv.querySelector('input[name$="[date_of_birth]"]');
                  const occupationInput = guarantorDiv.querySelector('input[name$="[occupation]"]');
                  const annualIncomeInput = guarantorDiv.querySelector('input[name$="[annual_income]"]');
  
                  if (nameInput) nameInput.value = customer.name || '';
                  if (contactInput) contactInput.value = customer.contact_number || '';
                  if (addressInput) addressInput.value = customer.address || '';
                  if (dobInput) dobInput.value = customer.date_of_birth || '';
                  if (occupationInput) occupationInput.value = customer.occupation || '';
                  if (annualIncomeInput) annualIncomeInput.value = (customer.monthly_income * 12) || '';
              }
          });
      };
  
      // Initialize existing guarantor
      document.querySelectorAll('.guarantor-item').forEach(initializeGuarantorListeners);
  
      // Add new guarantor functionality
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
                      <label for="guarantors[${guarantorIndex}][national_id]" class="block text-sm font-medium">National ID</label>
                      <select name="guarantors[${guarantorIndex}][national_id]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                          <option value="">Select NIC</option>
                          ${customers.map(customer => `
                              <option value="${customer.national_id}">${customer.national_id} - ${customer.name}</option>
                          `).join('')}
                      </select>
                  </div>
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
  
          // Add event listeners for minimize/remove buttons
          guarantorTemplate.querySelector('.remove-btn').addEventListener('click', () => {
              guarantorTemplate.remove();
              guarantorIndex--;
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
          
          // Initialize listeners for the new guarantor
          initializeGuarantorListeners(guarantorTemplate);
          
          guarantorIndex++;
      });
  });
      </script>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', () => {

    const amountInput = document.getElementById('amount');
        const totalWithInterestInput = document.getElementById('total_with_interest');
        const installmentDurationSelect = document.getElementById('installment_duration');
        const installmentAmountInput = document.getElementById('installment_amount');

        const calculateTotalWithInterest = (amount) => {
            const interestRate = 0.10; // 10% per month
            const months = 2; // 2 months
            return amount + (amount * interestRate * months);
        };

        const calculateInstallmentAmount = (total, duration) => {
            if (duration === 'daily') {
                return total / 60; // 60 days
            } else if (duration === 'weekly') {
                return total / 8; // 8 weeks
            }
            return 0;
        };

        amountInput.addEventListener('input', () => {
            const amount = parseFloat(amountInput.value) || 0;
            const totalWithInterest = calculateTotalWithInterest(amount);
            totalWithInterestInput.value = totalWithInterest.toFixed(2);

            // Update installment amount based on selected duration
            const duration = installmentDurationSelect.value;
            const installmentAmount = calculateInstallmentAmount(totalWithInterest, duration);
            installmentAmountInput.value = installmentAmount.toFixed(2);
        });

        installmentDurationSelect.addEventListener('change', () => {
            const totalWithInterest = parseFloat(totalWithInterestInput.value) || 0;
            const duration = installmentDurationSelect.value;
            const installmentAmount = calculateInstallmentAmount(totalWithInterest, duration);
            installmentAmountInput.value = installmentAmount.toFixed(2);
        });




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


$(document).ready(function() {
    // Initialize Select2 for existing select elements
    initializeSelect2();

    // Function to initialize Select2
    function initializeSelect2() {
        $('.searchable').select2({
            placeholder: 'Type to search...',
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,
            templateResult: formatResult,
            templateSelection: formatSelection
        });
    }

    // Custom formatting for dropdown items
    function formatResult(item) {
        if (!item.id) return item.text;
        if (item.element.parentElement.id === 'customer_id') {
            return $(`<span>ID: ${item.id} - ${item.text}</span>`);
        } else {
            // For guarantor NIC selects
            return $(`<span>${item.id} - ${item.text.split(' ').slice(1).join(' ')}</span>`);
        }
    }

    // Custom formatting for selected item
    function formatSelection(item) {
        if (!item.id) return item.text;
        if (item.element.parentElement.id === 'customer_id') {
            return `ID: ${item.id} - ${item.text}`;
        } else {
            return `${item.id} - ${item.text.split(' ').slice(1).join(' ')}`;
        }
    }

    // Re-initialize Select2 when adding new guarantor
    const originalAddGuarantor = document.getElementById('add-guarantor').onclick;
    document.getElementById('add-guarantor').onclick = function() {
        originalAddGuarantor.apply(this, arguments);
        // Wait for DOM update
        setTimeout(() => {
            const newGuarantor = document.querySelector('.guarantor-item:last-child');
            $(newGuarantor).find('select').select2({
                placeholder: 'Type to search...',
                allowClear: true,
                width: '100%',
                minimumInputLength: 1,
                templateResult: formatResult,
                templateSelection: formatSelection
            });
        }, 100);
    };
});

      </script>
@endpush

@endsection
