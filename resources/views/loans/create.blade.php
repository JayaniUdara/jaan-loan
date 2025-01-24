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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Loan Application Form</h1>

    <form method="POST" action="{{ route('loans.store') }}">
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


 {{-- <div class="mb-4">
    <label for="customer_id" class="block text-sm font-medium">Customer ID</label>


    <select id="customer_id" name="customer_id" class="mt-1 block w-full border-gray-300 rounded-md searchable">
        <option value="">Select Customer</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}</option>
        @endforeach
    </select>
</div> --}}

    <div class="mb-4">
        <label for="customer_id" class="block text-sm font-medium">Customer ID</label>
        <div class="relative">
            <input
                type="text"
                id="customer_search"
                class="mt-1 block w-full border-gray-300 rounded-md"
                placeholder="Search by Customer ID or Name"
                onfocus="showCustomerDropdown()"
                oninput="filterCustomers(this.value)"
            />
            <ul id="customer-dropdown" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md hidden max-h-60 overflow-auto">
                <!-- Customer options will be dynamically populated here -->
            </ul>
            <input type="hidden" id="customer_id" name="customer_id" />
        </div>
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

        <!-- Guarantors Details -->
        <h2 class="text-lg font-bold mt-6 mb-4">Guarantors</h2>
        <div id="guarantors-container">
            <div class="guarantor-item border p-4 mb-4 rounded-md">
                <h3 class="font-medium flex justify-between items-center">Guarantor 1
                    <button type="button" class="minimize-btn text-sm text-blue-500 ml-2">Minimize</button>
                    <button type="button" class="remove-btn text-sm text-red-500 ml-2">Remove</button>
                </h3>
                <div class="guarantor-details">


                    {{-- <div class="mb-4">
                        <label for="guarantors[0][national_id]" class="block text-sm font-medium">National ID</label>
                        <select name="guarantors[0][national_id]" class="mt-1 block w-full border-gray-300 rounded-md searchable" required>
                            <option value="">Select NIC</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->national_id }}">{{ $customer->national_id }} {{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-4">
                        <label for="guarantors[0][national_id]" class="block text-sm font-medium">National ID</label>
                        <div class="relative">
                            <input
                                type="text"
                                id="guarantor_search"
                                class="mt-1 block w-full border-gray-300 rounded-md"
                                placeholder="Search by National ID or Name"
                                onfocus="showGuarantorDropdown()"
                                oninput="filterGuarantors(this.value)"
                                autocomplete="off"
                                required
                            />
                            <ul id="guarantor-dropdown" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md hidden max-h-60 overflow-auto">
                                <!-- Guarantor options will be dynamically populated -->
                            </ul>
                            <input type="hidden" id="guarantor_id" name="guarantors[0][national_id]" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][name]" class="block text-sm font-medium">Name</label>
                        <input type="text" id="guarantor_name" name="guarantors[0][name]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][contact]" class="block text-sm font-medium">Contact</label>
                        <input type="text" id="guarantor_contact" name="guarantors[0][contact]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][address]" class="block text-sm font-medium">Address</label>
                        <input type="text" id="guarantor_address" name="guarantors[0][address]" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][relationship]" class="block text-sm font-medium">Relationship</label>
                        <input type="text" id="guarantor_relationship" name="guarantors[0][relationship]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][date_of_birth]" class="block text-sm font-medium">Date of Birth</label>
                        <input type="date" id="guarantor_dob" name="guarantors[0][date_of_birth]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][occupation]" class="block text-sm font-medium">Occupation</label>
                        <input type="text" id="guarantor_occupation" name="guarantors[0][occupation]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][annual_income]" class="block text-sm font-medium">Annual Income</label>
                        <input type="number" step="0.01" id="guarantor_income" name="guarantors[0][annual_income]" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="guarantors[0][additional_notes]" class="block text-sm font-medium">Additional Notes</label>
                        <textarea id="guarantor_notes" name="guarantors[0][additional_notes]" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
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
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

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
@endpush



<script>

    const guarantors = @json($customers); // Pass guarantor data from backend

    // Show all guarantors when the input gains focus
    function showGuarantorDropdown() {
        const dropdown = document.getElementById("guarantor-dropdown");
        dropdown.classList.remove("hidden");
        populateGuarantorDropdown(guarantors);
    }

    // Filter guarantors based on the input value
    function filterGuarantors(query) {
        const filteredGuarantors = guarantors.filter(guarantor =>
            guarantor.national_id.toLowerCase().includes(query.toLowerCase()) ||
            guarantor.name.toLowerCase().includes(query.toLowerCase())
        );
        populateGuarantorDropdown(filteredGuarantors);
    }

    // Populate the dropdown with filtered or all guarantors
    function populateGuarantorDropdown(data) {
        const dropdown = document.getElementById("guarantor-dropdown");
        dropdown.innerHTML = ""; // Clear existing options

        if (data.length === 0) {
            dropdown.innerHTML = `<li class="p-2 text-sm text-gray-500">No results found</li>`;
            return;
        }

        data.forEach(guarantor => {
            const listItem = document.createElement("li");
            listItem.className = "p-2 cursor-pointer hover:bg-gray-200";
            listItem.textContent = `${guarantor.national_id} - ${guarantor.name}`;
            listItem.onclick = () => selectGuarantor(guarantor);
            dropdown.appendChild(listItem);
        });
    }

    // Set the selected guarantor in the input and hidden field, and autofill other fields
    function selectGuarantor(guarantor) {
        document.getElementById("guarantor_search").value = `${guarantor.national_id} - ${guarantor.name}`;
        document.getElementById("guarantor_id").value = guarantor.national_id;

        // Autofill other fields
        document.getElementById("guarantor_name").value = guarantor.name;
        document.getElementById("guarantor_contact").value = guarantor.contact_number || "";
        document.getElementById("guarantor_address").value = guarantor.address || "";
        document.getElementById("guarantor_relationship").value = guarantor.relationship || "";
        document.getElementById("guarantor_dob").value = guarantor.date_of_birth || "";
        document.getElementById("guarantor_occupation").value = guarantor.occupation || "";
        document.getElementById("guarantor_income").value = (guarantor.monthly_income * 12) || "";
        document.getElementById("guarantor_notes").value = guarantor.additional_notes || "";

        // Hide the dropdown after selection
        document.getElementById("guarantor-dropdown").classList.add("hidden");
    }

    // Hide dropdown when clicking outside the input or dropdown
    document.addEventListener("click", (event) => {
        const dropdown = document.getElementById("guarantor-dropdown");
        const searchInput = document.getElementById("guarantor_search");

        if (!dropdown.contains(event.target) && event.target !== searchInput) {
            dropdown.classList.add("hidden");
        }
    });


</script>



<script>

    const customers = @json($customers); // Pass customers data from backend

    // Show the dropdown with all customers when the input gains focus
    function showCustomerDropdown() {
        const dropdown = document.getElementById("customer-dropdown");
        dropdown.classList.remove("hidden");
        populateCustomerDropdown(customers);
    }

    // Filter customers based on input value
    function filterCustomers(query) {
        const filteredCustomers = customers.filter(customer =>
            customer.id.toString().toLowerCase().includes(query.toLowerCase()) ||
            customer.name.toLowerCase().includes(query.toLowerCase())
        );
        populateCustomerDropdown(filteredCustomers);
    }

    // Populate the dropdown with customer options
    function populateCustomerDropdown(data) {
        const dropdown = document.getElementById("customer-dropdown");
        dropdown.innerHTML = ""; // Clear existing options

        if (data.length === 0) {
            dropdown.innerHTML = `<li class="p-2 text-sm text-gray-500">No results found</li>`;
            return;
        }

        data.forEach(customer => {
            const listItem = document.createElement("li");
            listItem.className = "p-2 cursor-pointer hover:bg-gray-200";
            listItem.textContent = `${customer.id} - ${customer.name}`;
            listItem.onclick = () => selectCustomer(customer);
            dropdown.appendChild(listItem);
        });
    }

    // Set the selected customer in the input and hidden field
    function selectCustomer(customer) {
        document.getElementById("customer_search").value = `${customer.id} - ${customer.name}`;
        document.getElementById("customer_id").value = customer.id;

        // Hide the dropdown after selection
        document.getElementById("customer-dropdown").classList.add("hidden");
    }

    // Hide dropdown when clicking outside
    document.addEventListener("click", (event) => {
        const dropdown = document.getElementById("customer-dropdown");
        const searchInput = document.getElementById("customer_search");

        if (!dropdown.contains(event.target) && event.target !== searchInput) {
            dropdown.classList.add("hidden");
        }
    });


</script>





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

@endsection