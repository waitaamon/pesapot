<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use Illuminate\Http\Request;

class CashReceiptActionsController extends Controller
{
    public function markTransferred(Request $request)
    {
        CashReceipt::find($request->receipts)
            ->each(fn($receipt) => $receipt->update(['status' => 'transferred']));
    }

    public function exportExcel()
    {
        
    }

    public function destroy(Request $request)
    {
        CashReceipt::find($request->receipts)
            ->each(fn($receipt) => $receipt->delete());
    }
}
