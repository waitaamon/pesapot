<?php

namespace App\Http\Requests\Supplier;


use App\Http\Requests\Supplier\StoreCashPaymentRequest;

class UpdateCashPaymentRequest extends StoreCashPaymentRequest
{

    public function rules():array
    {
        return parent::rules();
    }
}
