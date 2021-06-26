<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Categories\Requests\CreateCategoryRequest;
use App\Shop\Categories\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use App\Shop\ShopLocalizations\Repositories\ShopLocalizationRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepo;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->categoryRepo->rootCategories('created_at', 'desc');

        return view('admin.categories.list', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shopLocalizations = app(ShopLocalizationRepository::class)->listShopLocalizations('id','asc');

        return view('admin.categories.create', [
            'categories' => $this->categoryRepo->listCategories('name', 'asc'),
            'shopLocalizations' => $shopLocalizations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category =$this->categoryRepo->createCategory($request->except('_token', '_method'));


        if($request->has('shop_id')) {
            $category->shopLocalizations()->sync($request->get('shop_id'));
        }




        return redirect()->route('admin.categories.index')->with('message', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepo->findCategoryById($id);

        $cat = new CategoryRepository($category);

        return view('admin.categories.show', [
            'category' => $category,
            'categories' => $category->children,
            'products' => $cat->findProducts()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepo->findCategoryById($id);
//        dd($category
//            ->shopLocalizations()
//            ->pluck('shop_localization_id')
//            ->all());
        $shopLocalizations = app(ShopLocalizationRepository::class)->listShopLocalizations('id','asc');
        return view('admin.categories.edit', [
            'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
            'category' => $category,
            'shopLocalizations' => $shopLocalizations,
            'selectedIds'=>$category
                ->shopLocalizations()
                ->pluck('shop_localization_id')
                ->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepo->findCategoryById($id);

        $update = new CategoryRepository($category);
        $update->updateCategory($request->except('_token', '_method'));
        if($request->has('shop_id')){
            $category->shopLocalizations()->sync($request->get('shop_id'));
        }

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = $this->categoryRepo->findCategoryById($id);
        $category->products()->sync([]);
        $category->shopLocalizations()->sync([]);
        $category->delete();


        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->categoryRepo->deleteFile($request->only('category'));
        request()->session()->flash('message', 'Image delete successful');
        return redirect()->route('admin.categories.edit', $request->input('category'));
    }

    public function rotateFarmers(Request $request)
    {
        $categories = $this->categoryRepo->listCategories('page_order', 'desc',null);

        $count = $categories->count();

        foreach ($categories as $category){

            if($category->page_order == 1) {
                $category->page_order = $count;
            }else{
                $category->page_order = $category->page_order - 1;
            }

            $category->save();

        }

        request()->session()->flash('message','Ordem dos Produtores alterada!');
        return redirect()->back();


    }

    public function listCategories()
    {
        $categories = $this->categoryRepo->listCategories('page_order', 'desc',null);

        return view('admin.categories.list-categories-batch')->with('categories',$categories);
    }

    public function listProductsBatch($id)
    {
        $category = $this->categoryRepo->findCategoryById($id);
        $products = $category->products()->get();

        return view('admin.categories.list-products-batch')->with(['products'=>$products,
        'category'=>$category->name]);
    }
}
