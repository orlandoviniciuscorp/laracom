<?php

namespace App\Shop\Addresses\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateAddressRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => ['required'],
            'address_1' => ['required'],
            'zip'=>['required'],
            'neighborhoods'=>['required'],
            'phone'=>['required']
        ];
    }

    public function messages()
    {
        return ['address_1.required' => 'O campo Endereço é obrigatório',
        'neighborhoods.required' => 'O campo Bairro é obrigatório',
        'alias.required' => 'O campo Tipo de Endereço é obrigatório',
        'zip.required' => 'O campo CEP é obrigatório',
        'phone.required' => 'O campo Telefone é obrigatório'];
    }
}
