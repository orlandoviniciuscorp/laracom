<?php

namespace App\Shop\ProductPercents\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateProductPercentRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'farmer'=>['numeric'],
            'plataform'=>['numeric'],
            'separation'=>['numeric'],
            'fund'=>['numeric'],
            'payments_transfer'=>['numeric'],
            'client_contact'=>['numeric'],
            'accounting_close'=>['numeric'],
            'seeller'=>['numeric'],
            'logistic'=>['numeric']

        ];
    }
}
