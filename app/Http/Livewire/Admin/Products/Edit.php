<?php

namespace App\Http\Livewire\Admin\Products;

use App\Shop\Producers\Repositories\ProducerRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Edit extends Component
{
    public $product;

    public $product_name;
    public $product_id;
    public $quantity;
    public $price;
    public $is_in_promotion;
    public $status =[];
    public $product_producers = [];
    //public $producerModel;

    public $listeners = ['productUpdated'=>'loadProduct',
                        'selectedProducersId',
        'saveProducers'=>'saveProducers'];

    public function render()
    {

        return view('livewire.admin.products.edit',
            ['product_name'=>$this->product_name],
            ['product_id'=>$this->product_id]);
    }

    public function mount($product)
    {
        $this->product = $product;
        $this->product_name = $product->name;
        $this->product_id = $product->id;
        $this->quantity = $product->quantity;
        $this->price = $product->price;
        $this->is_in_promotion = (bool) $product->is_in_promotion;
        $this->status = $product->status;
        $this->product_producers = $product->producers()->pluck('producers.id');

       // dd(self::$producers);

    }

    public function updating($field,$value)
    {

    }

    public function saveProducers($producers,$product_id)
    {
        if($this->product_id == $product_id) {
            $this->product_producers = $producers;
            $this->product->producers()->sync($this->product_producers);
        }
    }
    public function loadProduct(){
        $this->mount(app(ProductRepository::class)->findProductById($this->product_id));
    }

    public function save()
    {

        $this->product->name = ($this->product_name);
        $this->product->id = ($this->product_id);
        $this->product->quantity = ($this->quantity);
        $this->product->price = ($this->price);
        $this->product->is_in_promotion = ($this->is_in_promotion);
        $this->product->status = ($this->status);
//        $this->product->product_producers = ($this->product_producers);
        $this->product->save();

    }

    public static function getProducers(){

        return app(ProducerRepository::class)->all();
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function update()
    {
        dump('oi');
    }

    public function selectedProducersId($id)
    {
        if($id){
            $this->product_producers = $id;
        }
    }
}
