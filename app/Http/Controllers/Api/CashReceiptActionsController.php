<?php

namespace App\Http\Controllers\Api;

use App\Models\CashReceipt;
use Illuminate\Http\Request;
use App\Exports\CashReceiptsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CashReceiptActionsController extends Controller
{
    public function markTransferred(Request $request)
    {
        CashReceipt::find($request->receipts)
            ->each(fn($receipt) => $receipt->update(['status' => 'transferred']));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new CashReceiptsExport($request->receipts), 'cash-receipts.xlsx');
    }

    public function destroy(Request $request)
    {
        CashReceipt::find($request->receipts)
            ->each(fn($receipt) => $receipt->delete());
    }
}
