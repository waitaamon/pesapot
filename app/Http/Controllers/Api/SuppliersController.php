<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Http\Resources\{SupplierResource, SuppliersCollection};
use App\Http\Requests\Supplier\{StoreSupplierRequest, UpdateSupplierRequest};

class SuppliersController extends Controller
{

    public function index()
    {
        $supplier = Supplier::paginate(request()->get('per_page'));

        return response(new SuppliersCollection($supplier));
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->only('name'));

        return response(new SupplierResource($supplier));
    }

    public function show(int $id)
    {
        $supplier = Supplier::with('payments')->findOrfail($id);

        return response(new SupplierResource($supplier));
    }

    public function update(UpdateSupplierRequest $request, int $id)
    {
        $supplier = Supplier::findOrfail($id);

        $supplier->update($request->only('name'));

        return response(new SupplierResource($supplier));
    }

    public function destroy(int $id)
    {
        $supplier = Supplier::findOrfail($id);

        if ($supplier->payments()->exists()) return;

        $supplier->delete();
    }
}
