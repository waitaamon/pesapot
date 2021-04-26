<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\{CustomerResource, CustomersCollection};
use App\Http\Requests\Customer\{StoreCustomerRequest, UpdateCustomerRequest};

class CustomersController extends Controller
{

    public function index()
    {
        $customers = Customer::paginate(request()->get('per_page'));

        return response(new CustomersCollection($customers));
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->only('name'));

        return response(new CustomerResource($customer));
    }

    public function show(int $id)
    {
        $customer = Customer::with('receipts')->findOrfail($id);

        return response(new CustomerResource($customer));
    }

    public function update(UpdateCustomerRequest $request, int $id)
    {
        $customer = Customer::findOrfail($id);

        $customer->update($request->only('name'));

        return response(new CustomerResource($customer));
    }

    public function destroy(int $id)
    {
        $customer = Customer::findOrfail($id);

        if ($customer->receipts()->exists()) return;

        $customer->delete();
    }
}
