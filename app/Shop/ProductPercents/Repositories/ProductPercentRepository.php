<?php

namespace App\Shop\ProductPercents\Repositories;

use App\Shop\AttributeValues\AttributeValue;
use App\Shop\ProductPercents\ProductPercent;
use App\Shop\Products\Exceptions\ProductCreateErrorException;
use App\Shop\Products\Exceptions\ProductUpdateErrorException;
use App\Shop\Tools\UploadableTrait;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Brands\Brand;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\ProductImages\ProductImage;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductPercentRepository extends BaseRepository
{
    use ProductTransformable, UploadableTrait;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(ProductPercent $productPercent)
    {
        parent::__construct($productPercent);
        $this->model = $productPercent;
    }


    public function createProductPercent(array $data)
    {

        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw $e;
        }
    }

}
