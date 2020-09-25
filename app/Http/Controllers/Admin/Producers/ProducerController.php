<?php

namespace App\Http\Controllers\Admin\Producers;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Producers\Repositories\ProducerRepository;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Http\Request;

class ProducerController extends Controller
{

    /**
     * @var CategoryRepositoryInterface
     */
    protected $producerRepo;

    /**
     * CategoryController constructor.
     *
     * @param ProducerRepository $producerRepository
     */
    public function __construct(ProducerRepository $producerRepository)
    {
        $this->producerRepo = $producerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->producerRepo->listProducers('created_at', 'desc');

        return view('admin.producers.list', [
            'producers' => $this->producerRepo->paginateArrayResults($list->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.producers.create', [
            'categories' => $this->producerRepo->listProducers('name', 'asc')
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
        $this->producerRepo->createCategory($request->except('_token', '_method'));

        return redirect()->route('admin.producers.index')->with('message', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->producerRepo->findCategoryById($id);

        $cat = new CategoryRepository($category);

        return view('admin.producers.show', [
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
        return view('admin.producers.edit', [
            'categories' => $this->producerRepo->listProducers('name', 'asc', $id),
            'category' => $this->producerRepo->findCategoryById($id)
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
        $category = $this->producerRepo->findCategoryById($id);

        $update = new CategoryRepository($category);
        $update->updateCategory($request->except('_token', '_method'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.producers.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = $this->producerRepo->findCategoryById($id);
        $category->products()->sync([]);
        $category->delete();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.producers.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->producerRepo->deleteFile($request->only('category'));
        request()->session()->flash('message', 'Image delete successful');
        return redirect()->route('admin.producers.edit', $request->input('category'));
    }

    public function rotateFarmers(Request $request)
    {
        $categories = $this->producerRepo->listProducers('page_order', 'desc',null);

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

    public function listProducers()
    {
        $categories = $this->producerRepo->listProducers('page_order', 'desc',null);

        return view('admin.producers.list-categories-batch')->with('categories',$categories);
    }

    public function listProductsBatch($id)
    {
        $category = $this->producerRepo->findCategoryById($id);
        $products = $category->products()->get();

        return view('admin.producers.list-products-batch')->with(['products'=>$products,
            'category'=>$category->name]);
    }
}