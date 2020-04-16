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
        $cartItems = $this->session()->get('cart')['default'];

        return [
            'courier_id' => ['required',
            function($attribute,$value,$fail){
                $cartItems = $this->session()->get('cart')['default'];
                foreach ($cartItems as $cartItem){
                    if($cartItem->qty >$cartItem->product->quantity){
                        $fail('O produto "'. $cartItem->name . '" possui '.
                            $cartItem->product->quantity . ' no estoque. Por favor, atualize o seu pedido');
                    }
                }
            }]
        ];
    }

    public function messages()
    {
        return ['courier_id.required' => 'Por favor escolha o lugar da Entrega'];
    }

    //foreach($carItens as $carItem){
    //            if($carItem->qty >$carItem->product->quantity){
    //                $error = true;
    //                $msg = ['O produto "'. $carItem->name . '" possui '. $carItem->product->quantity . ' no estoque. Por favor, atualize o seu pedido'];
    //               $msgErros = array_merge($msgErros,$msg);
    //            }
    //        }
}
