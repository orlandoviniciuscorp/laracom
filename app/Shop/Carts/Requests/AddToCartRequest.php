<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;

class AddToCartRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product' => ['required', 'integer','soldout'],
            'quantity' => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return ['product.soldout'=>'Infelizmente o produto esgotou'];
    }
}
