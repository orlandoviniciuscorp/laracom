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

class HarverstPaymentExport implements  FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
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

    public function headings(): array
    {

        return [
            'Categoria',
            'Produto',
            'Quantidade',
            'Valor Vendido',
            'Valor Produtor',
            'Plataforma',
            'Separação',
            'Caixinha',
            'Pagamentos',
            'Contato Clientes',
            'Contas',
            'Conferencia',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"R$ "#,##0.00_-',
            'E' => '"R$ "#,##0.00_-',
            'F' => '"R$ "#,##0.00_-',
            'G' => '"R$ "#,##0.00_-',
            'H' => '"R$ "#,##0.00_-',
            'I' => '"R$ "#,##0.00_-',
            'J' => '"R$ "#,##0.00_-',
            'K' => '"R$ "#,##0.00_-',
            'L' => '"R$ "#,##0.00_-',
        ];
    }

    public function collection()
    {
//        return collect([$this->fairRepo->getExtract($this->fair_id)]);
        //dd(collect($this->fairRepo->getHarverstPayment($this->fair_id)));
        return collect($this->fairRepo->getHarverstPayment($this->fair_id));
    }



}