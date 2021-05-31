<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\CashPayment;
use App\Http\Controllers\Controller;
use App\Http\Resources\{CashPaymentResource, CashPaymentsCollection, SupplierResource};
use App\Http\Requests\Supplier\{StoreCashPaymentRequest, UpdateCashPaymentRequest};

class CashPaymentsController extends Controller
{
    public function prerequisites()
    {
        $suppliers = Supplier::all();

        return response()->json([
            'suppliers' => SupplierResource::collection($suppliers)
        ]);
    }

    public function index()
    {
        $payments = CashPayment::query()
            ->when(request()->filled('status'), fn($query) => $query->where('status', request()->get('status')))
            ->when(request()->filled('supplier'), fn($query) => $query->where('supplier_id', request()->get('supplier')))
            ->when(request()->filled('from'), fn($query) => $query->whereDate('date', '>=', Carbon::parse(request()->get('from'))))
            ->when(request()->filled('to'), fn($query) => $query->whereDate('date', '<=', Carbon::parse(request()->get('to'))))
            ->orderBy('date', 'desc')
            ->paginate(request()->get('per_page'));

        return response(new CashPaymentsCollection($payments));
    }

    public function store(StoreCashPaymentRequest $request)
    {
        $payment = CashPayment::create(array_merge($request->only('amount', 'note'), [
            'supplier_id' => $request->supplier,
            'user_id' => auth()->id(),
            'date' => Carbon::parse($request->date)
        ]));

        return response(new CashPaymentResource($payment));
    }

    public function show(int $id)
    {
        $payment = CashPayment::with('supplier', 'user')->findOrFail($id);

        return response(new CashPaymentResource($payment));
    }

    public function update(UpdateCashPaymentRequest $request, int $id)
    {
        $payment = CashPayment::findOrFail($id);

        abort_if($payment->status == 'transferred', 403, 'You are unauthorized to perform this action');

        $payment->update(array_merge($request->only('amount', 'note'), [
            'supplier_id' => $request->supplier,
            'date' => Carbon::parse($request->date)
        ]));

        return response(new CashPaymentResource($payment));
    }

    public function destroy(int $id)
    {
        $payment = CashPayment::findOrFail($id);

        abort_if($payment->status == 'transferred', 403, 'You are unauthorized to perform this action');

        $payment->delete();
    }
}
