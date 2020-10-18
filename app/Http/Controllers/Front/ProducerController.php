<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Producers\Repositories\ProducerRepository;

class ProducerController extends Controller
{


    /**
     * ProducerController constructor.
     *
     * @param ProducerRepositoryInterface $producerRepository
     */
    public function __construct(ProducerRepository $producerRepository,
                                ConfigurationRepository $configurationRepository,
                                CategoryRepositoryInterface $categoryRepository)
    {
        $this->producerRepo = $producerRepository;
        $this->categoryRepo = $categoryRepository;
        $this->configRepo = $configurationRepository;
    }

    /**
     * Find the producer via the slug
     *
     * @param string $slug
     * @return \App\Shop\Categories\Producer
     */
    public function getProducer(string $slug)
    {
        $producer = $this->producerRepo->findProducerBySlug(['slug' => $slug]);

        $repo = new ProducerRepository($producer);

        $products = $repo->findProducts()->where('status', 1)->all();
//        dd($products);

        return view('front.producers.producer', [
            'producers'=>$this->getProducerOrder(),
            'cats'=>$this->getCategoryOrder(),
            'producer' => $producer,
            'products' => $repo->paginateArrayResults($products, 20),
            'config'=>$this->getConfig()
        ]);
    }

    public function listProductsBatch($id)
    {
        $producer = $this->productRepo->findProducerById($id);
        $products = $producer->products()->get();

        return view('admin.categories.list-products-batch')->with(['products'=>$products,
            'category'=>$producer->name]);
    }
}
