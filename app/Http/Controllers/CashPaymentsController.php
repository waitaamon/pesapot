<?php

namespace App\Http\Controllers;

class CashPaymentsController extends Controller
{
    public function __invoke()
    {
        return view('cash-payments');
    }
}
