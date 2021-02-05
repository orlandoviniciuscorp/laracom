<?php


namespace App\Exports;


use App\Invoice;
use App\Shop\Fairs\Repositories\FairRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HarverstExport implements FromView
{
    use Exportable;
    protected $fair_id;
    protected $fairRepo;
    protected $orderRepo;
    public function __construct($fairRepo,$orderRepo,$fair_id)
    {
        $this->fairRepo =$fairRepo;
        $this->orderRepo =$orderRepo;
        $this->fair_id = $fair_id;
    }

//    public function headings(): array
//    {
//        return [
//            'Categoria',
//            'Produto',
//            'Quantidade',
//            'Valor Vendido',
//            'Custo produto',
//        ];
//    }
//
//    public function columnFormats(): array
//    {
//        return [
//            'D' => '"R$ "#,##0.00_-',
//            'E' => '"R$ "#,##0.00_-',
//        ];
//    }

//    public function collection()
//    {
//        return collect([$this->fairRepo->getExtract($this->fair_id)]);
//        return collect($this->fairRepo->getHarverstPayment($this->fair_id));
//    }


    public function view(): View
    {
        $harvest = $this->fairRepo->harvest($this->fair_id);
        $fair = $this->fairRepo->findFairById($this->fair_id);

        $data = ['harvest'=>$harvest, 'fair'=>$fair];
         return view('invoices.harvest', $data);
    }
}