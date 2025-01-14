<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //  dd('in customer controller ');
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|unique:customers,contact_number|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'national_id' => 'nullable|string|unique:customers,national_id|max:50',
            'occupation' => 'nullable|string|max:255',
            'monthly_income' => 'nullable|numeric|min:0',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('profile_photo_path')) {
            $validated['profile_photo_path'] = $request->file('profile_photo_path')->store('profile_photos', 'public');
        }

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

 /**
     * Show the form for editing the specified customer.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }



    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20|unique:customers,contact_number,' . $id,
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'national_id' => 'nullable|string|max:50|unique:customers,national_id,' . $id,
            'occupation' => 'nullable|string|max:255',
            'monthly_income' => 'nullable|numeric|min:0',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_photo_path')) {
            // Delete the old image if it exists
            if ($customer->image) {
                Storage::delete('public/' . $customer->image);
            }
        }
        
        $customer->update($validatedData);
      //  dd($customer);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }
    public function updateApprove($id)
{
    $customer = Customer::findOrFail($id);
    $customer->update(['is_approved' => true]);

    return redirect()->route('customers.index')->with('success', 'Customer approved successfully.');
}


    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Optional: Add logic to handle related data like loans, payments, etc.
        if ($customer->loans()->exists()) {
            return redirect()->route('customers.index')->with('error', 'Customer cannot be deleted as they have associated loans.');
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function approve($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->update([
            'is_approved' => true,
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Customer approved successfully.');
    }
}
