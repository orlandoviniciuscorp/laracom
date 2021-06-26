<?php

namespace App\Shop\ShopLocalizations\Repositories;

use App\Shop\ShopLocalizations\ShopLocalization;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Shop\ShopLocalizations\Repositories\Interfaces\ShopLocalizationRepositoryInterface;

class ShopLocalizationRepository extends BaseRepository implements ShopLocalizationRepositoryInterface
{
	/**
     * ShopLocalizationRepository constructor.
     * 
     * @param ShopLocalization $dummy
     */
    public function __construct(ShopLocalization $dummy)
    {
        parent::__construct($dummy);
        $this->model = $dummy;
    }

    /**
     * List all the ShopLocalizations
     *
     * @param string $order
     * @param string $sort
     * @param array $except
     * @return \Illuminate\Support\Collection
     */
    public function listShopLocalizations(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * Create ShopLocalization
     *
     * @param array $params
     *
     * @return ShopLocalization
     * @throws InvalidArgumentException
     */
    public function createShopLocalization(array $params) : ShopLocalization
    {
        try {
        	return ShopLocalization::create($params);
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the dummy
     *
     * @param array $params
     * @return ShopLocalization
     */
    public function updateShopLocalization(array $params) : ShopLocalization
    {
        $dummy = $this->findShopLocalizationById($this->model->id);
        $dummy->update($params);
        return $dummy;
    }

    /**
     * @param int $id
     * 
     * @return ShopLocalization
     * @throws ModelNotFoundException
     */
    public function findShopLocalizationById(int $id) : ShopLocalization
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete a dummy
     *
     * @return bool
     */
    public function deleteShopLocalization() : bool
    {
        return $this->model->delete();
    }
}