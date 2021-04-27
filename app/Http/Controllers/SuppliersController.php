<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

class SuppliersController extends Controller
{
    public function index()
    {
        return view('suppliers.index');
    }

    public function show(int $id)
    {
        $supplier = Supplier::with('payments')->withSum('activePayments', 'amount')->findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }
}
