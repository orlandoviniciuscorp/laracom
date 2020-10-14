<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Configurations\Repositories\ConfigurationRepository;

class CategoryController extends Controller
{


    /**
     * CategoryController constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository,
                                ConfigurationRepository $configurationRepository)
    {
        $this->categoryRepo = $categoryRepository;
        $this->configRepo = $configurationRepository;
    }

    /**
     * Find the category via the slug
     *
     * @param string $slug
     * @return \App\Shop\Categories\Category
     */
    public function getCategory(string $slug)
    {
        $category = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);

        $repo = new CategoryRepository($category);

        $products = $repo->findProducts()->where('status', 1)->sortBy('name')->all();

        return view('front.categories.category', [
            'cats'=>$this->getCategoryOrder(),
            'category' => $category,
            'products' => $repo->paginateArrayResults($products, 20),
            'config'=>$this->getConfig()
        ]);
    }
}
