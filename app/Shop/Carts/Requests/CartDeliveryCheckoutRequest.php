<?php

namespace App\Shop\Cart\Requests;

use App\Shop\Base\BaseFormRequest;

/**
 * Class CartCheckoutRequest
 * @package App\Shop\Cart\Requests
 * @codeCoverageIgnore
 */
class CartDeliveryCheckoutRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'courier_id' => ['required']
        ];
    }

    public function messages()
    {
        return ['courier_id.required' => 'Por favor escolha o lugar da Entrega'];
    }
}
