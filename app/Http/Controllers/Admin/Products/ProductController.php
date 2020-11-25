<?php

namespace App\Http\Controllers\Admin\Products;

use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Percentages\Repositories\PercentageRepository;
use App\Shop\Producers\Repositories\ProducerRepository;
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
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ProductTransformable, UploadableTrait;





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

    /**
     * @var ProducerRepository
     */
    protected $producerRepo;

    protected $percentageRepo;

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
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttribute $productAttribute,
        BrandRepositoryInterface $brandRepository,
        ProductPercentRepository $productPercentRepository,
        ProducerRepository $producerRepository,
        PercentageRepository $percentageRepository
    ) {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->attributeRepo = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttribute = $productAttribute;
        $this->brandRepo = $brandRepository;
        $this->productPercentRepo = $productPercentRepository;
        $this->producerRepo = $producerRepository;
        $this->percentageRepo = $percentageRepository;

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
        $products = $this->getAllProducts();

        return view('admin.products.list', [
            'products' => $this->productRepo->paginateArrayResults($products, 25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->listCategories('name', 'asc');
        $nextSKU = $this->productRepo->countProducts() + 1;
        $percentages = $this->percentageRepo->listPercentages('id');

        $producers = $this->producerRepo->listProducers('name', 'asc');


        return view('admin.products.create', [
            'categories' => $categories,
            'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
            'default_weight' => env('SHOP_WEIGHT'),
            'weight_units' => Product::MASS_UNIT,
            'product' => new Product,
            'nextSKU' => $nextSKU,
            'percentages'=>$percentages,
            'producers'=>$producers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->except('_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->productRepo->saveCoverImage($request->file('cover'));
        }


        $product = $this->productRepo->createProduct($data);



        $productRepo = new ProductRepository($product);

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }

        if ($request->has('producers')) {

            $productRepo->syncProducers($request->input('producers'));
        } else {
            $productRepo->detachProducers();
        }

        $request->session()->flash('message', $this->getSucessMesseger());

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {

        //dd(request()->has('is_distinct'));

        $product = $this->productRepo->findProductById($id);
        $productAttributes = $product->attributes()->get();

        $qty = $productAttributes->map(function ($item) {
            return $item->quantity;
        })->sum();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productAttributes->where('id', request()->input('pa'))->first();
            $pa->attributesValues()->detach();
            $pa->delete();

            request()->session()->flash('message', $this->getSucessMesseger());
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }

        $categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();
        $producers = $this->producerRepo->listProducers('name', 'asc');
        $percentages = $this->percentageRepo->listPercentages('id');

        return view('admin.products.edit', [
            'product' => $product,
            'images' => $product->images()->get(['src']),
            'categories' => $categories,
            'selectedIds' => $product->categories()->pluck('category_id')->all(),
            'attributes' => $this->attributeRepo->listAttributes(),
            'productAttributes' => $productAttributes,
            'qty' => $qty,
            'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
            'weight' => $product->weight,
            'default_weight' => $product->mass_unit,
            'weight_units' => Product::MASS_UNIT,
            'producers'=>$producers,
            'percentages'=>$percentages,
            'producersSelectedIds'=>$product->producers()->pluck('producer_id')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\Products\Exceptions\ProductUpdateErrorException
     */
    public function update(UpdateProductRequest $request, int $id)
    {

        $product = $this->productRepo->findProductById($id);

        $productRepo = new ProductRepository($product);

        if ($request->has('attributeValue')) {
            $this->saveProductCombinations($request, $product);
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1])
                ->with('message', $this->getSucessMesseger());
        }

        $data = $request->except(
            'categories',
            '_token',
            '_method',
            'default',
            'image',
            'productAttributeQuantity',
            'productAttributePrice',
            'attributeValue',
            'combination',
            'origin',
            'producers'
        );

        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover')) {
            $data['cover'] = $productRepo->saveCoverImage($request->file('cover'));
        }

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }

        if ($request->has('producers')) {
            $productRepo->syncProducers($request->input('producers'));
        } else {
            $productRepo->detachProducers();
        }

        $productRepo->updateProduct($data);
        if($request->has('origin')){
            $page = $request->input('origin');

            return Redirect::to($page)->with('message', $this->getSucessMesseger());
        }
        return redirect()->back()
            ->with('message', $this->getSucessMesseger());
    }

    public function updateQuantity(Request $request)
    {



        $product = $this->productRepo->find($request->input('id'));
        $product->quantity = $request->input('quantity');
        $product->save();

        $products = $this->getAllProducts();

        $request->session()->flash('message', $this->getSucessMesseger());

//        return view('admin.products.list', [
//            'products' => $this->productRepo->paginateArrayResults($products, 25)
//        ]);

        return redirect()->back()->with('message',$this->getSucessMesseger());


    }

    public function updateQuantityBatch(Request $request)
    {
//        dd($request->all());
        $data = $request->except('_token');

//        dd($data);

        $product = null;
        foreach ($data as $key => $value) {

            $fragment = explode("_",$key);
            if($fragment[0] == "id"){
                $product = $this->productRepo->find($value);
            } if($fragment[0] == "name"){
                $product->name = $value;
            } if($fragment[0] == "status"){
                $product->status = $value;

            } if($fragment[0] == "price"){

                $product->price = $value;
            } if($fragment[0] == "quantity"){
                $product->quantity = $value;

//                $product = null;
            }
            $product->save();
            if($fragment[0] == "producers") {

//                dd();
                $pr = new ProductRepository($product);
                if (is_null($value)) {

                    $pr->detachProducers();
                } else {
                    $pr->syncProducers($value);
                }
                $product = null;

            }


        }

        $request->session()->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.producer.list.products')->with('message',$this->getSucessMesseger());
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

    public function emptyAvailability()
    {
        $products = $this->getAllProducts();

        foreach($products as $product){

            if($product->name!='Sacola Retornável') {
                $p = $this->productRepo->find($product->id);
                $p->quantity = 0;
                $p->save();
            }
        }
        request()->session()->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.dashboard');
    }

    public function disableEmptyProducts(Request $request)
    {
        $products = $this->getAllProducts();

        foreach ($products as $product){
            if($product->quantity == 0){
                $p = $this->productRepo->find($product->id);
                $p->status = 0;
                $p->save();
            }
        }
        request()->session()->flash('message', $this->getSucessMesseger());
        return redirect()->route('admin.dashboard');
    }

    public function disabledProduct($id)
    {
        $product = $this->productRepo->find($id);

        $product->status = 0;
        $product->save();

        request()->session()->flash('message', $this->getSucessMesseger());
        return redirect()->back();
    }

    public function enabledProduct($id)
    {
        $product = $this->productRepo->find($id);

        $product->status = 1;
        $product->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = $this->productRepo->findProductById($id);
        $product->categories()->sync([]);
        $productAttr = $product->attributes();

        $productAttr->each(function ($pa) {
            DB::table('attribute_value_product_attribute')->where('product_attribute_id', $pa->id)->delete();
        });

        $productAttr->where('product_id', $product->id)->delete();

        $productRepo = new ProductRepository($product);
        $productRepo->removeProduct();

        return redirect()->route('admin.products.index')->with('message', $this->getSucessMesseger());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->productRepo->deleteFile($request->only('product', 'image'), 'uploads');
        return redirect()->back()->with('message', $this->getSucessMesseger());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeThumbnail(Request $request)
    {
        $this->productRepo->deleteThumb($request->input('src'));
        return redirect()->back()->with('message', $this->getSucessMesseger());
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return boolean
     */
    private function saveProductCombinations(Request $request, Product $product): bool
    {
        $fields = $request->only(
            'productAttributeQuantity',
            'productAttributePrice',
            'sale_price',
            'default'
        );

        if ($errors = $this->validateFields($fields)) {
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1])
                ->withErrors($errors);
        }

        $quantity = $fields['productAttributeQuantity'];
        $price = $fields['productAttributePrice'];

        $sale_price = null;
        if (isset($fields['sale_price'])) {
            $sale_price = $fields['sale_price'];
        }

        $attributeValues = $request->input('attributeValue');
        $productRepo = new ProductRepository($product);

        $hasDefault = $productRepo->listProductAttributes()->where('default', 1)->count();

        $default = 0;
        if ($request->has('default')) {
            $default = $fields['default'];
        }

        if ($default == 1 && $hasDefault > 0) {
            $default = 0;
        }

        $productAttribute = $productRepo->saveProductAttributes(
            new ProductAttribute(compact('quantity', 'price', 'sale_price', 'default'))
        );

        // save the combinations
        return collect($attributeValues)->each(function ($attributeValueId) use ($productRepo, $productAttribute) {
            $attribute = $this->attributeValueRepository->find($attributeValueId);
            return $productRepo->saveCombination($productAttribute, $attribute);
        })->count();
    }

    /**
     * @param array $data
     *
     * @return
     */
    private function validateFields(array $data)
    {
        $validator = Validator::make($data, [
            'productAttributeQuantity' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
    }

    public function getAllProducts()
    {
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }else if(request()->has('categories')){
            $list = $this->productRepo->listProducts('name')
                ->whereIn('category_id', request()->get('categories'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        return $products;
    }

    public function getAllEnabledProduct()
    {
        $list = $this->productRepo->listProducts('id')->where('status','=',1);

        if(request()->has('categories')){
            $list = $this->productRepo->listProducts('name')
                ->whereIn('category_id', request()->get('categories'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        return $products;
    }
    public function listAllProduct()
    {

        $product = null;
        if(request()->has('include_disables') && request()->get('include_disables') == 1){
            $products = $this->getAllProducts();
        }else{
            $products = $this->getAllEnabledProduct();
        }

//        dd($products->where('name','like','%123%'));

        $categories = $this->getCategoryOrder();

        $producers = $this->producerRepo->listProducers('name', 'asc');

        return view('admin.products.edit-products-batch')->with(['products'=>$products,
        'producers'=>$producers,
            'categories'=>$categories]);

    }
}
