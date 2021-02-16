<?php

namespace App\Console\Commands;

use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Fairs\Fair;
use App\Shop\Fairs\Repositories\FairRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateFair extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organicosaat:create:fair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fairs for sells';

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
        if ($config->automatic_fair) {
            $fairRepo = app(FairRepository::class);
            $fair = new Fair();

            $fair->name = $config->fair_name . $config->next_fair_number;
            $fair->start_at = Carbon::now();
            $fair->end_at = Carbon::parse('next saturday');
            $fair->status = 1;

            $oldFair = $fairRepo->findFairById($fairRepo->findLastFair());
            //            dd($oldFair);
            $oldFair->status = 0;
            $oldFair->save();

            $fair->save();

            $config->next_fair_number = $config->next_fair_number + 1;

            $configRepo->updateConfig($config);
            dump('Feira Criada');
        } else {
            dump('Criação de Feira Desabilitado');
        }
    }
}
