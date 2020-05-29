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

        foreach($fair->orders as $order) {
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
                    case 1 || 4:
                        $order->order_status_id = 1;
                        break;
                    case 3:
                        $order->order_status_id = 2;
                        break;
                }
//            }else{

                //$order->status = env('ORDER_CANCELED');
                $order->save();
            }
        }
    }
}
