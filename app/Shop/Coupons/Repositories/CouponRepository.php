<?php

namespace App\Shop\Coupons\Repositories;

use App\Shop\Coupons\Coupon;
use App\Shop\Percentages\ProductPercent;
use App\Shop\Tools\UploadableTrait;
use Carbon\Carbon;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Products\Product;

use App\Shop\Products\Transformations\ProductTransformable;

use Illuminate\Database\QueryException;


class CouponRepository extends BaseRepository
{
    use ProductTransformable, UploadableTrait;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Coupon $coupon)
    {
        parent::__construct($coupon);
        $this->model = $coupon;
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

    public function listCoupons(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {

        return $this->all($columns, $order, $sort);
    }

}
