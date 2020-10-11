<?php

namespace App\Http\Controllers\Admin\Producers;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Producers\Producer;
use App\Shop\Producers\Repositories\ProducerRepository;
use App\Shop\Producers\Requests\CreateProducerRequest;
use App\Shop\Producers\Requests\UpdateProducerRequest;
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
    public function store(CreateProducerRequest $request)
    {
        $this->producerRepo->createProducer($request->except('_token', '_method'));

        return redirect()->route('admin.producers.index')->with('message', 'Produtor criado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producer = $this->producerRepo->findProducerById($id);

        $cat = new ProducerRepository($producer);

        return view('admin.producers.show', [
            'producer' => $producer,
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
            'producers' => $this->producerRepo->listProducers('name', 'asc', $id),
            'producer' => $this->producerRepo->findProducerById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProducerRequest $request, $id)
    {
        $producer = $this->producerRepo->findProducerById($id);

        $update = new ProducerRepository($producer);
        $update->updateProducer($request->except('_token', '_method'));

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
        $producer = $this->producerRepo->findProducerById($id);
        $producer->products()->sync([]);
        $producer->delete();

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



    public function listProducers()
    {
        $producers = $this->producerRepo->listProducers('name', 'desc',null);

        return view('admin.producers.list-producers-batch')->with('producers',$producers);
    }

    public function listProductsBatch($id)
    {
        $producer = $this->producerRepo->findProducerById($id);
        $products = $producer->products()->get();

        return view('admin.producers.list-products-batch')->with(['products'=>$products,
            'producer'=>$producer->name]);
    }
}