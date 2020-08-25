<?php

namespace App\Shop\Checkout\Requests;

use App\Shop\Base\BaseFormRequest;

/**
 * Class CartCheckoutRequest
 * @package App\Shop\Cart\Requests
 * @codeCoverageIgnore
 */
class CheckoutRequest extends BaseFormRequest
{



    public function messages()
    {
        $messages = [
            'payment_method.required' => 'Por favor escolha um método de Pagamento',
            'address_id.required'=>'Por favor escolha um endereço'
        ];

        return $messages;

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method' => ['required'],
            'address_id' => ['required']
        ];
    }
}
