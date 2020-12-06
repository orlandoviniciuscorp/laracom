<?php

namespace App\Shop\Coupons\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateCouponRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>['required'],
            'description'=>['required'],
            'percentage'=>['required'],
            'need_basket'=>['required'],
            'start_at'=>['required'],
            'expires_at'=>['required'],
            'status'=>['required'],
            'include_delivery'=>['required'],
            'coupon_type_id' =>['required']
        ];
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'Por favor preencha o campo Nome',
            'description.required' => 'Por favor preencha o campo Descrição',
            'percentage.required' => 'Por favor preencha o campo Valor',
            'start_at.required' => 'Por favor preencha o campo de Início da Validade',
            'expires_at.required' => 'Por favor preencha o campo de data de Expiração',
            'status.required' => 'Por favor preencha o campo de Status',
            'include_delivery.required' => 'Por favor preencha se precisa incluir o frete',
            'coupon_type_id.required' => 'Por favor preencha o campo Tipo de Cupom',
        ];
        return $messages;
    }
}
