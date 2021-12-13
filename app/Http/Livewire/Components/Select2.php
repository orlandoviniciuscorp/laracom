<?php

namespace App\Http\Livewire\Components;

use App\Shop\Producers\Repositories\ProducerRepository;
use Livewire\Component;

class Select2 extends Component
{

    public static $producers;
    public $product_id;
    public $product_producers;

    public $producersModel;

    public $listeners = ['selectedProducersId'];

    public function boot()
    {
        if(is_null(self::$producers)){

            self::$producers = self::getProducers();
        }

    }

    public function render()
    {
        return view('livewire.components.select2');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updated()
    {
        $this->emit('saveProducers',$this->product_producers,$this->product_id);
    }

    public static function getProducers(){

        return app(ProducerRepository::class)->all();
    }
}
