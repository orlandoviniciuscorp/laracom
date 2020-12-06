<?php

namespace App\Shop\CouponTypes\Repositories;

use App\Shop\CouponTypes\CouponType;
use App\Shop\Percentages\ProductPercent;
use App\Shop\Tools\UploadableTrait;
use Carbon\Carbon;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Products\Product;

use App\Shop\Products\Transformations\ProductTransformable;

use Illuminate\Database\QueryException;


class CouponTypeRepository extends BaseRepository
{
    use ProductTransformable, UploadableTrait;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(CouponType $couponType)
    {
        parent::__construct($couponType);
        $this->model = $couponType;
    }


    public function store(array $data)
    {
//        $data['start_at'] = Carbon::parse($data['start_at']);
//        $data['expires_at'] = Carbon::parse($data['expires_at']);
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function listCouponTypes(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {

        return $this->all($columns, $order, $sort);
    }

}
