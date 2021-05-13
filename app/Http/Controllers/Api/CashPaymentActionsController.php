<?php

namespace App\Http\Controllers\Api;

use App\Models\CashPayment;
use Illuminate\Http\Request;
use App\Exports\CashPaymentsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CashPaymentActionsController extends Controller
{
    public function markTransferred(Request $request)
    {
        CashPayment::find($request->payments)
            ->each(function ($payment) {
                if ($payment->status == 'active') {
                    $payment->update(['status' => 'transferred']);
                }
            });
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new CashPaymentsExport($request->payments), 'cash-payments.xlsx');
    }

    public function destroy(Request $request)
    {
        CashPayment::find($request->payments)
            ->each(fn($payment) => $payment->delete());
    }
}
