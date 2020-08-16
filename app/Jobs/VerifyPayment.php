<?php

namespace App\Jobs;

use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LivePixel\MercadoPago\MP;

class VerifyPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $fair;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        /**
         *
         * API de Retorno do Mercado Pago
         *  approved - accredited
         *  in_process - pending_contingency
         *  in_process - pending_review_manual
         *  rejected - cc_rejected_bad_filled_card_number
         *  rejected - cc_rejected_bad_filled_date
         *  rejected - cc_rejected_bad_filled_other
         *  rejected - cc_rejected_bad_filled_security_code
         *  rejected - cc_rejected_blacklist
         *  rejected - cc_rejected_call_for_authorize
         *  rejected - cc_rejected_card_disabled
         *  rejected - cc_rejected_card_error
         *  rejected - cc_rejected_duplicated_payment
         *  rejected - cc_rejected_high_risk
         *  rejected - cc_rejected_insufficient_amount
         *  rejected - cc_rejected_invalid_installments
         *  rejected - cc_rejected_max_attempts
         *  rejected - cc_rejected_other_reason

         */

        $fairRepo = new FairRepository(new Fair);
        $fair = $fairRepo->findFairById($fairRepo->findLastFair());

//        dd($fair->orders());
        $mp = new MP(env('MP_APP_ID'), env('MP_APP_SECRET'));
        foreach($fair->orders as $order) {

//                //Verificar o pagamento dos pedidos feitos no mercado-pago
            if(!is_null($order->mercado_pago_reference_id)){


                $retorno = $mp->get(
                    "/v1/payments/search",
                    array(
                        "external_reference" => $order->reference
                    )
                );
//                    dump($retorno);
                $results = $retorno['response']['results'];
                if(!empty($results)){
                    dump($order->id);
                    $status = $results[0]['status_detail'];
                    dump($status);

                    if($status == "cc_rejected_bad_filled_card_number"
                        ||$status ==  "cc_rejected_bad_filled_date"
                        ||$status ==  "cc_rejected_bad_filled_other"
                        ||$status ==  "cc_rejected_bad_filled_security_code"
                        ||$status ==  "cc_rejected_blacklist"
                        ||$status ==  "cc_rejected_call_for_authorize"
                        ||$status ==  "cc_rejected_card_disabled"
                        ||$status ==  "cc_rejected_card_error"
                        ||$status ==  "cc_rejected_duplicated_payment"
                        ||$status ==  "cc_rejected_high_risk"
                        ||$status ==  "cc_rejected_insufficient_amount"
                        ||$status ==  "cc_rejected_invalid_installments"
                        ||$status ==  "cc_rejected_max_attempts"
                        ||$status ==  "cc_rejected_other_reason") {
                        dump('recusado');
                        $order->order_status_id = 3;
                    }
                    if($status == 'pending_contingency' ||
                        $status ==  'pending_review_manual' ||
                        $status ==  'pending_waiting_payment') {
                        dump('pendente');
                        $order->order_status_id = 2;
                    }

                    if($status == 'accredited'){
                        dump('aprovado');
                        $order->order_status_id = 1;

                    }
                    $order->save();

                }
            }
//                    dd($order);
        }
    }
}
