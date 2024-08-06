<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::all();
        return Inertia::render('Customer/Index', ['customers' => $customers]);
    }

    public function create(){
        return Inertia::render('Customer/Create');
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'customer_email' => 'required|string|lowercase|email|max:255|unique:customers,customer_email',
            'phone_number' => 'required|string|size:11|unique:customers,phone_number',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'county' => 'nullable|string|max:255',
            'postcode' => 'required|string|size:7',
        ]);

        Customer::create($validatedData);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }
}
