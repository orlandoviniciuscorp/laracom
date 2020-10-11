<?php

namespace App\Shop\Producers\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateProducerRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:producers']
        ];
    }
}
