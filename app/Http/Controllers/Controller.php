<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cartRepo;

    protected $productRepo;

    protected $configRepo;

    protected function loggedUser()
    {
        return auth()->user();
    }

    public function getSucessMesseger(){
        return "Atualizado com Sucesso!";
    }


    public function getConfig()
    {
        return $this->configRepo->getConfig();
    }


}
