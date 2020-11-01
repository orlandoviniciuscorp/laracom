<?php


namespace App\Exports;


use App\Invoice;
use App\Shop\Fairs\Repositories\FairRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FinancialExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;
    const FORMAT_CURRENCY_BRL_SIMPLE = '"R$ "#,##0.00_-';
    protected $fair_id;
    protected $fairRepo;
    protected $orderRepo;
    public function __construct($fairRepo,$orderRepo,$fair_id)
    {
        $this->fairRepo =$fairRepo;
        $this->orderRepo =$orderRepo;
        $this->fair_id = $fair_id;
    }

    public function headings(): array
    {
        return [
            'Tipo de Entrega',
            'TIpo de Pagamento',
            'Total de Produtos',
            'Total de Entregas',
            'Total',
            'Quantidade de Pedidos'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '"R$ "#,##0.00_-',
            'D' => '"R$ "#,##0.00_-',
            'E' => '"R$ "#,##0.00_-',
        ];
    }

    public function collection()
    {
        $data = ['financial'=>$this->fairRepo->getExtract($this->fair_id)];
        $data = array_merge($data,['productors'=>$this->fairRepo->getHarverstPayment($this->fair_id)]);
        $data = array_merge($data,['fair'=>$this->fairRepo->find($this->fair_id)]);
        $data = array_merge($data,['totalOrders'=>$this->orderRepo->totalOrders($this->fair_id)]);
        $data = array_merge($data,['totalAmount'=>$this->orderRepo->totalAmount($this->fair_id)]);

//        return collect([$this->fairRepo->getExtract($this->fair_id)]);
        return collect($this->fairRepo->getExtract($this->fair_id));
    }



}