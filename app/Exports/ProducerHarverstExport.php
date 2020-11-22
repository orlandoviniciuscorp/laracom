<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ProducerHarverstExport implements FromView
{
    use Exportable;
    protected $fair_id;
    protected $fairRepo;
    protected $orderRepo;
    protected $productRepo;
    public function __construct($fairRepo,$orderRepo,$productRepo,$fair_id)
    {
        $this->fairRepo =$fairRepo;
        $this->orderRepo =$orderRepo;
        $this->fair_id = $fair_id;
        $this->productRepo = $productRepo;
    }

    public function view(): View
    {
        $harvest = $this->fairRepo->harvest($this->fair_id);
        $data = Array();

//    dump($harvest);

        foreach($harvest as $item){
            $product = $this->productRepo->findProductById($item->id);
            $quantity = Array();
//            dd($product->producers->count());
            foreach ($product->producers as $producer){

                $quantity[$producer->name] =  0;
            }
            $productQuantity = $item->quantidade;
//            dd($quantity);

            while($productQuantity != 0){
                foreach($quantity as $key=>$value)
                    if($productQuantity != 0){
                        $quantity[$key] = $value+1;
                        $productQuantity--;
                    }
            }
            array_push($data, ['produto' =>$product->name,'produtor'=>$quantity]);

        }


//        dump($pd);
//        dd($data);

//        $data = ['harvest'=>$harvest];
        return view('invoices.producer-harvest', ['colheita'=>$data]);
    }
}