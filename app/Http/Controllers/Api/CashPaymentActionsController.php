<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CashPayment;
use Illuminate\Http\Request;

class CashPaymentActionsController extends Controller
{
    public function markTransferred(Request $request)
    {
        CashPayment::find($request->payments)
            ->each(fn($payment) => $payment->update(['status' => 'transferred']));
    }

    public function exportExcel()
    {
        
    }

    public function destroy(Request $request)
    {
        CashPayment::find($request->payments)
            ->each(fn($payment) => $payment->delete());
    }
}
