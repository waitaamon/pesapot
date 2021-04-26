<?php

namespace App\Http\Controllers;

class CustomersController extends Controller
{
    public function __invoke()
    {
        return view('customers');
    }
}
