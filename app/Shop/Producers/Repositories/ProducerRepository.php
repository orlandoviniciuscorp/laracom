<?php

namespace App\Shop\Producers\Repositories;

use Illuminate\Support\Facades\DB;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Producers\Producer;
use App\Shop\Producers\Exceptions\ProducerInvalidArgumentException;
use App\Shop\Producers\Exceptions\ProducerNotFoundException;
use App\Shop\Producers\Repositories\Interfaces\ProducerRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class ProducerRepository extends BaseRepository implements ProducerRepositoryInterface
{
    use UploadableTrait, ProductTransformable;

    /**
     * ProducerRepository constructor.
     * @param Producer $producer
     */
    public function __construct(Producer $producer)
    {
        parent::__construct($producer);
        $this->model = $producer;
    }

    /**
     * List all the producers
     *
     * @param string $order
     * @param string $sort
     * @param array $except
     * @return \Illuminate\Support\Collection
     */
    public function listProducers(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    public function pageOrder(){

        return $this->model->orderBy('id')->get();

    }

    public function allActive()
    {
        return $this->model->where('status',1)->orderBy('id')->get();
    }


    /**
     * List all root producers
     * 
     * @param  string $order 
     * @param  string $sort  
     * @param  array  $except
     * @return \Illuminate\Support\Collection  
     */
    public function rootProducers(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->whereIsRoot()
                        ->orderBy($order, $sort)
                        ->get()
                        ->except($except);
    }

    /**
     * Create the producer
     *
     * @param array $params
     *
     * @return Producer
     * @throws ProducerInvalidArgumentException
     * @throws ProducerNotFoundException
     */
    public function createProducer(array $params) : Producer
    {
        try {

            $collection = collect($params);
            if (isset($params['name'])) {
                $slug = str_slug($params['name']);
            }

            if (isset($params['cover']) && ($params['cover'] instanceof UploadedFile)) {
                $cover = $this->uploadOne($params['cover'], 'producers');
            }else{
                $cover = null;
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $producer = new Producer($merge->all());

            if (isset($params['parent'])) {
                $parent = $this->findProducerById($params['parent']);
                $producer->parent()->associate($parent);
            }

            $producer->save();
            return $producer;
        } catch (QueryException $e) {
            throw new ProducerInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the producer
     *
     * @param array $params
     *
     * @return Producer
     * @throws ProducerNotFoundException
     */
    public function updateProducer(array $params) : Producer
    {
        $producer = $this->findProducerById($this->model->id);
        $collection = collect($params)->except('_token');
        $slug = str_slug($collection->get('name'));

        if (isset($params['cover']) && ($params['cover'] instanceof UploadedFile)) {
            $cover = $this->uploadOne($params['cover'], 'producers');
        }else{
            $cover = null;
        }

        $merge = $collection->merge(compact('slug', 'cover'));

        $producer->update($merge->all());
        
        return $producer;
    }

    /**
     * @param int $id
     * @return Producer
     * @throws ProducerNotFoundException
     */
    public function findProducerById(int $id) : Producer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProducerNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete a producer
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteProducer() : bool
    {
        return $this->model->delete();
    }

    /**
     * Associate a product in a producer
     *
     * @param Product $product
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function associateProduct(Product $product)
    {
        return $this->model->products()->save($product);
    }

    /**
     * Return all the products associated with the producer
     *
     * @return mixed
     */
    public function findProducts() : Collection
    {
        return $this->model->products;
    }

    /**
     * @param array $params
     */
    public function syncProducts(array $params)
    {
        $this->model->products()->sync($params);
    }


    /**
     * Detach the association of the product
     *
     */
    public function detachProducts()
    {
        $this->model->products()->detach();
    }

    /**
     * @param $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null) : bool
    {
        return $this->update(['cover' => null], $file['producer']);
    }

    /**
     * Return the producer by using the slug as the parameter
     *
     * @param array $slug
     *
     * @return Producer
     * @throws ProducerNotFoundException
     */
    public function findProducerBySlug(array $slug) : Producer
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new ProducerNotFoundException($e);
        }
    }

    /**
     * @return mixed
     */
    public function findParentProducer()
    {
        return $this->model->parent;
    }

    /**
     * @return mixed
     */
    public function findChildren()
    {
        return $this->model->children;
    }

    public function verifyProductDetail($product_id, $producer_id)
    {
        $count = DB::select('select count(id) is_available from producer_details where product_id = ? and producer_id = ?',
        [$product_id,$producer_id]);

        return ($count[0]->is_available > 0);
    }
}
