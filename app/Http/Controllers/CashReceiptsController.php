<?php

namespace App\Http\Controllers;

class CashReceiptsController extends Controller
{
    public function __invoke()
    {
        return view('cash-receipts');
    }
}
