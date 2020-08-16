<?php

namespace App\Console\Commands;

use App\Shop\Configurations\Repositories\ConfigurationRepository;
use Illuminate\Console\Command;

class ClosePlataform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nadespensa:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close the plataform for sells';

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
        $config->is_open = false;
        $configRepo->updateConfig($config);
        dump($config->is_open);
    }
}
