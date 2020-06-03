<?php

namespace App\Jobs;

use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VerifyPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $fair;

    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fairRepo = new FairRepository(new Fair);
        $fair = $fairRepo->findFairById($fairRepo->findLastFair());

        /**
         * Tabela do PagSeguro:
         *  1 - Aguardando pagamento
         *  2 - Em análise
         *  3 - Paga
         *  4 - Disponível
         *  5 - Em disputa
         *  6 - Devolvida
         *  7 - Cancelada
         *  8 - Debitado
         *  9 - Retenção temporária
         */

        /**
         * Tabela Demedeiros:
         *
         *
        1	paid	green	2020-04-06 00:11:48	2020-04-06 00:11:48
        2	pending	yellow	2020-04-06 00:11:48	2020-04-06 00:11:48
        3	error	red	2020-04-06 00:11:48	2020-04-06 00:11:48
        4	on-delivery	blue	2020-04-06 00:11:48	2020-04-06 00:11:48
        5	Pedido Feito	violet	2020-04-06 00:11:48	2020-04-19 21:20:17

         */

        foreach($fair->orders as $order) {

            if($order->order_status_id != 1){

                $Url = env('PAGSEGURO_TRANSACTIONS') . "?email=" .
                    env('PAGSEGURO_EMAIL') .
                    "&token=" . env('PAGSEGURO_TOKEN') .
                    "&reference=" . $order->reference;

                $Curl = curl_init($Url);
                curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
                $retorno = curl_exec($Curl);
                curl_close($Curl);

                $xml = simplexml_load_string($retorno);
                if ($xml->resultsInThisPage->__toString() == "1") {
                    $status = $xml->transactions->transaction->status->__toString();

                    switch ($status) {
                        case 1 || 2:
                            $order->order_status_id = 2;
                            break;
                        case 3 || 4:
                            $order->order_status_id = 1;
                            break;
                        case 6 || 7:
                            $order->order_status_id = 6;
                            break;
                    }
    //            }else{

                    //$order->status = env('ORDER_CANCELED');
                    $order->save();
                }
            }
        }
    }
}
