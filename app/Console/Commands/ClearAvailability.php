<?php

namespace App\Console\Commands;

use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use App\Shop\Products\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearAvailability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organicosaat:clear-availability';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Availability';

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
        $configRepo = app(ConfigurationRepository::class);
        $config = $configRepo->getConfig();
        if ($config->automatic_clear_availability) {
            $productRepo = app(ProductRepository::class);
            $productRepo->emptyAvailability();

            dump('Disponibilidade Zerada!');
        } else {
            dump('o Evento de zerar a disponibilidade está desabilitado');
        }
    }
}
