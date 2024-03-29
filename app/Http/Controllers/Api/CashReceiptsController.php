<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Carbon\Carbon;
use App\Models\CashReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\{CashReceiptResource, CashReceiptsCollection, CustomerResource};
use App\Http\Requests\Customer\{StoreCashReceiptRequest, UpdateCashReceiptRequest};

class CashReceiptsController extends Controller
{
    public function prerequisites()
    {
        $customers = Customer::all();

        return response()->json([
            'customers' => CustomerResource::collection($customers)
        ]);
    }

    public function index()
    {
        $receipts = CashReceipt::query()
            ->when(request()->filled('status'), fn($query) => $query->where('status', request()->get('status')))
            ->when(request()->filled('customer'), fn($query) => $query->where('customer_id', request()->get('customer')))
            ->when(request()->filled('from'), fn($query) => $query->whereDate('date', '>=', Carbon::parse(request()->get('from'))))
            ->when(request()->filled('to'), fn($query) => $query->whereDate('date', '<=', Carbon::parse(request()->get('to'))))
            ->orderBy('date', 'desc')
            ->paginate(request()->get('per_page'));

        return response(new CashReceiptsCollection($receipts));
    }

    public function store(StoreCashReceiptRequest $request)
    {
        $receipt = CashReceipt::create(array_merge($request->only('amount', 'note'), [
            'customer_id' => $request->customer,
            'user_id' => auth()->id(),
            'date' => Carbon::parse($request->date)
        ]));

        return response(new CashReceiptResource($receipt));
    }

    public function show(int $id)
    {
        $receipt = CashReceipt::with('customer', 'user')->findOrFail($id);

        return response(new CashReceiptResource($receipt));
    }

    public function update(UpdateCashReceiptRequest $request, int $id)
    {
        $receipt = CashReceipt::findOrFail($id);

        abort_if($receipt->status == 'transferred', 403, 'You are unauthorized to perform this action');

        $receipt->update(array_merge($request->only('amount', 'note'), [
            'customer_id' => $request->customer,
            'date' => Carbon::parse($request->date)
        ]));

        return response(new CashReceiptResource($receipt));
    }

    public function destroy(int $id)
    {
        $receipt = CashReceipt::findOrFail($id);

        abort_if($receipt->status == 'transferred', 403, 'You are unauthorized to perform this action');

        $receipt->delete();
    }
}
