<?php

namespace App\Shop\Products\Requests;

use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => ['required'],
            'name' => ['required', Rule::unique('products')->ignore($this->segment(3))],
            'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'categories' =>['required'],
            'producers' =>['required']
        ];
    }

    public function messages()
    {
        return [
            'sku.required' => 'O Código é obrigatório',
            'name.required' => 'O Nome do produto é obrigatório',
            'name.unique'=>'Já existe um produto com esse nome',
            'quantity.required' => 'Por favor informe a quantidade',
            'quantity.numeric' =>'O valor da quantidade tem que ser um número',
            'price.required'=> 'Por favor informe o preço do produto',
            'cover.required'=>'Por favor preencha a foto de capa',
            'categories.required'=>'Por favor informar a categoria',
            'producers.required'=>'Por favor informar o produtor',
        ];
    }
}
