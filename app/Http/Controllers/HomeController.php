<?php

namespace App\Http\Controllers;

use App\Models\CashPayment;
use App\Models\CashReceipt;

class HomeController extends Controller
{
    public function __invoke()
    {
        $totalPayment = CashPayment::query()->active()->sum('amount');
        $totalReceipt = CashReceipt::query()->active()->sum('amount');

        $balance = $totalReceipt - $totalPayment;

        return view('dashboard', compact('totalReceipt', 'totalPayment', 'balance'));
    }
}
