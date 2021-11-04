<?php

namespace App\Http\Livewire;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use Livewire\Component;

class CartCounter extends Component
{

    public $cartCount = 0;
    public $totalCartItens = 0.00;

    protected $listeners = ['productAdded' => 'updateCart'];
    public function render()
    {

        $this->cartCount = $this->getCartCount();
        $this->totalCartItens = $this->getTotalItems();

        return view('livewire.cart-counter');
    }

    public function mount(){

        $this->cartCount = $this->getCartCount();
        $this->totalCartItens = $this->getTotalItems();
    }

    public function updateCart()
    {
        $this->cartCount = $this->getCartCount();
        $this->totalCartItens = $this->getTotalItems();
    }

    /**
     * @return int
     */
    private function getCartCount()
    {
        $cartRepo = new CartRepository(new ShoppingCart());
        return $cartRepo->countItems();
    }

    private function getTotalItems()
    {
        $cartRepo = new CartRepository(new ShoppingCart());
        return $cartRepo->getTotal();
    }
}
