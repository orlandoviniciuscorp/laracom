<?php

namespace App\Console\Commands;

use App\Shop\Configurations\Repositories\ConfigurationRepository;
use Illuminate\Console\Command;

class CloseRioPlataform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organicosaat:closeRio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close the plataform for sells in Rio';

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
        $configRioRepo = app(ConfigurationRepository::class);


        $configRio = $configRioRepo->getConfigRio();
        if($configRio->is_automatic_close) {
            $configRio->is_open = false;
            $configRioRepo->updateConfig($configRio);
            dump($configRio->is_open);
        }else{
            dump('Fechamento automático desligada');
        }

    }
}
