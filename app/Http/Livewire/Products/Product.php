<?php

namespace App\Http\Livewire\Products;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Product extends Component
{
    use ProductTransformable;


    public $product_id;

    public $quantity = 1;

    public $product;

    public $inStock = false;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $rules =
        [
            'product_id' => ['required', 'integer','soldout'],
            'quantity' => ['required', 'integer']
        ];

    protected $messages = ['product_id.soldout' => 'O Produto acabou',
        'validation.soldout'=>'O Produto acabou'];


    public function render()
    {

        return view('livewire.products.product',['quantity'=>1]);
    }

    public function mount($product)
    {
        $this->inStock = $product->quantity > 0;

        $this->product_id = $product->id;

//        $this->product = $this->listProducts();
    }

    public function submit()
    {
        $validator = Validator::make([$this->product_id],['soldout'],['soldout'=>'O Produto acabou']);


        if($validator->fails()){
            $this->dispatchBrowserEvent('swal', [
                'title' => $validator->errors()->first(),
                'timer'=>3000,
                'icon'=>'error',
                'toast'=>true,
                'position'=>'top-right'
            ]);
        }
        $validator->validate();

        $product = app(ProductRepository::class)->findProductById($this->product_id);

//        dd($this->quantity);
        $retorno = app(CartRepository::class)->addToCart($product, $this->quantity, []);
        $this->emit('productAdded');
        $this->product = app(ProductRepository::class)->findProductById($this->product_id);

        $this->dispatchBrowserEvent('swal', [
            'title' => $product->name .' adicionado ao carrinho',
            'timer'=>3000,
            'icon'=>'success',
            'toast'=>true,
            'position'=>'top-right'
        ]);

    }

    public function updated(){
        $this->product = app(ProductRepository::class)->findProductById($this->product_id);
        $this->inStock = $this->product->quantity > 0;

    }
}
