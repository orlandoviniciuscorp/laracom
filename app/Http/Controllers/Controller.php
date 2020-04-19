<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cartRepo;

    protected $productRepo;

    protected function loggedUser()
    {
        return auth()->user();
    }

    public function getSucessMesseger(){
        return "Atualizado com Sucesso!";
    }

    public function neededBag()
    {

        if (env('NEEDED_BAG') == 1){

            if ((!is_null(auth()->user())) && auth()->user()->countBought() < 1 && hasbag()) {

                $product = $this->productRepo->findByProductName('Sacola Retornável');
                $options = [];
                $this->cartRepo->addToCart($product, 1, $options);
            }
        }


    }

    public function hasbag()
    {
        $carItens = $this->cartRepo->getCartItemsTransformed();

        foreach ($carItens as $carItem) {
            if ($carItem->name == 'Sacola Retornável') {
                return true;

            }
        }
        return false;
    }


}
