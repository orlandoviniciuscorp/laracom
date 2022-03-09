<?php

namespace App\Console\Commands;

use App\Shop\Configurations\Repositories\ConfigurationRepository;
use Illuminate\Console\Command;

class OpenRioPlataform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organicosaat:openRio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open the plataform for sells on Rio';

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
        if($configRio->is_automatic_open) {
            $configRio->is_open = true;
            $configRioRepo->updateConfig($configRio);
            dump($configRio->is_open);
        }else{
            dump('Abertura automática desligada');
        }

    }
}
