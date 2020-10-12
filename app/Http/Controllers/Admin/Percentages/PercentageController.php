<?php

namespace App\Http\Controllers\Admin\Percentages;

use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Percentages\Repositories\PercentageRepository;
use App\Shop\Percentages\Requests\CreatePercentageRequest;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\ProductPercents\ProductPercent;
use App\Shop\ProductPercents\Repositories\ProductPercentRepository;
use App\Shop\Products\Exceptions\ProductInvalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\ProductPercents\Requests\CreateProductPercentRequest;
use App\Shop\Products\Requests\CreateProductRequest;
use App\Shop\Products\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PercentageController extends Controller
{
    use UploadableTrait;


    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepo;

    protected $productPercentRepo;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepo;

    /**
     * @var AttributeValueRepositoryInterface
     */
    protected $attributeValueRepository;

    /**
     * @var ProductAttribute
     */
    protected $productAttribute;

    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepo;

    protected $percentageRepository;

    /**
     * ProductController constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     * @param ProductAttribute $productAttribute
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        PercentageRepository $percentageRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttribute $productAttribute,
        BrandRepositoryInterface $brandRepository,
        ProductPercentRepository $productPercentRepository
    ) {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->attributeRepo = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttribute = $productAttribute;
        $this->brandRepo = $brandRepository;
        $this->productPercentRepo = $productPercentRepository;
        $this->percentageRepository = $percentageRepository;

        $this->middleware(['permission:create-product, guard:employee'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:update-product, guard:employee'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete-product, guard:employee'], ['only' => ['destroy']]);
        $this->middleware(['permission:view-product, guard:employee'], ['only' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $percentages = $this->getAllPercentages();

        return view('admin.percentages.list', [
            'percentages' => $percentages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.percentages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePercentageRequest $request)
    {
        $data = $request->except('_token', '_method');

        $percentage = $this->percentageRepository->store($data);

        $request->session()->flash('message', $this->getSucessMesseger());

        return redirect()->route('admin.percentages.index');
    }

    public function update(CreatePercentageRequest $request)
    {
        $data = $request->except('_token', '_method');

        $percentage = $this->percentageRepository->find($data['id']);

        $update = new PercentageRepository($percentage);

        $update->update($data);

        $request->session()->flash('message', $this->getSucessMesseger());

        return redirect()->route('admin.percentages.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $percentage_id)
    {
        $percentage = $this->percentageRepository->find($percentage_id);
//        dd($percentage);

        return view('admin.percentages.edit')->with('percentage',$percentage);

    }

    public function indexPercent(Request $request, int $product_id)
    {
        $product = $this->productRepo->findProductById($product_id);

        return view('admin.percents.create')->with('product',$product);
    }

    public function percentStore(CreateProductPercentRequest $request, int $product_id)
    {


        $data = $request->except('_token', '_method');
        $this->productPercentRepo->createProductPercent($data);
        $product = $this->productRepo->findProductById($product_id);
        return redirect()->route('admin.products.edit', $product_id);
    }


    public function getAllPercentages()
    {
        $list = $this->percentageRepository->listPercentages('id');
        return $list;
    }
}
