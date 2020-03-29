<?php

namespace App\Shop\Carts\Requests;

use App\Shop\Base\BaseFormRequest;

class UpdateCartRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => ['required', 'integer','gt:0']
        ];
    }

    public function messages()
    {
        return ['quantity.gt' => 'A quantidade de Itens não pode ser Zero. Para retirar, por favor clique em remover'];
    }
}
