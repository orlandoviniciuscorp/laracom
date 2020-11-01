<?php


namespace App\Exports;


use App\Invoice;
use App\Shop\Fairs\Repositories\FairRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrdersDetailExport implements FromArray, WithHeadings, ShouldAutoSize, WithColumnFormatting
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
            'Pedido',
            'Cliente',
            'Telefone',
            'E-mail',
            'Tipo de Pagamento',
            'Produtos',
            'Entrega',
            'Total Pago',
            'Status',
            'Obs',

        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '"R$ "#,##0.00_-',
            'G' => '"R$ "#,##0.00_-',
            'H' => '"R$ "#,##0.00_-',
        ];
    }

    public function array(): array
    {

        $orders = $this->orderRepo->findByFairId($this->fair_id);

        $data = null;
        foreach($orders as $key => $order){
           $data =  array_add($data, $key,
            array('pedido' => '#'.$order->id,
            'cliente'=>$order->customer->name,
            'telefone'=>$order->address->phone,
            'email'=>$order->customer->email,
            'tipo_pagamento'=>$order->payment,
            'produtos'=>$order->total_products,
            'entrega'=>$order->total_shipping,
            'total'=>$order->total,
            'status'=>$order->orderStatus->name,
                'obs'=>$order->obs)
            );
        }
//        dd($data);
//        return collect([$this->fairRepo->getExtract($this->fair_id)]);
        return $data;
    }



}