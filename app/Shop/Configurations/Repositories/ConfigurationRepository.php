<?php

namespace App\Shop\Configurations\Repositories;

use App\Shop\AttributeValues\AttributeValue;
use App\Shop\Configurations\Configuration;
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

class ConfigurationRepository extends BaseRepository
{
    use ProductTransformable, UploadableTrait;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);
        $this->model = $configuration;
    }

    public function updateConfig(Configuration $configuration)
    {
        $this->model = $configuration;
        return $this->model->save();
    }

    public function getConfig()
    {
        return $this->model->first();

    }
   

    
}
