<?php

namespace App\Http\Requests\Customer;


class UpdateCashReceiptRequest extends StoreCashReceiptRequest
{

    public function rules():array
    {
        return parent::rules();
    }
}
