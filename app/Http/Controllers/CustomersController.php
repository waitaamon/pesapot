<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CustomersController extends Controller
{
    public function index()
    {
        return view('customers.index');
    }

    public function show(int $id)
    {
        $customer = Customer::with('receipts')->withSum('activeReceipts', 'amount')->findOrFail($id);

        return view('customers.show', compact('customer'));
    }
}
