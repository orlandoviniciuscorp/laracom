<?php

namespace App\Console\Commands;

use App\Shop\Configurations\Repositories\ConfigurationRepository;
use Illuminate\Console\Command;

class OpenPlataform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organicosaat:open';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open the plataform for sells';

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
        if($config->is_automatic_open) {
            $config->is_open = true;
            $configRepo->updateConfig($config);
            dump($config->is_open);
        }else{
            dump('Abertura automática desligada');
        }

    }
}
