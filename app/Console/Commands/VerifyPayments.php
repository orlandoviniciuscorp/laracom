<?php

namespace App\Console\Commands;

use App\Jobs\VerifyPayment;
use Illuminate\Console\Command;

class VerifyPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nadespensa:verifypayment {--queue=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica os pagamentos para a feira da semana';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        VerifyPayment::dispatchNow();
    }
}
