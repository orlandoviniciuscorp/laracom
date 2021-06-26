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

    protected $categoryRepo;

    protected $producerRepo;

    protected function loggedUser()
    {
        return auth()->user();
    }

    public function getSucessMesseger($item = null){
        return $item . " atualizado(a) com Sucesso!";
    }


    public function getConfig()
    {
//        dd(current_shop());
        if(current_shop() == 2 && !auth()->guard('employee')->check()) {
//            dd('aaaaaaaaaaaaaa');
            return $this->configRepo->getConfigRio();
        }else{
            return $this->configRepo->getConfig();
        }
    }

    public function getConfigRio()
    {
        return $this->configRepo->getConfigRio();
    }

    public function getCategoryOrder(){
        return $this->categoryRepo->pageOrder();
    }

    public function getProducerOrder(){
        return $this->producerRepo->pageOrder();
    }


}
