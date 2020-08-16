<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Configurations\Repositories\ConfigurationRepository;

class HomeController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */


    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository,
    ConfigurationRepository $configurationRepository)
    {
        $this->categoryRepo = $categoryRepository;
        $this->configRepo = $configurationRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cats = $this->categoryRepo->pageOrder();

        return view('front.index')->with('cats',$cats)
            ->with('config',$this->getConfig());
    }
}
