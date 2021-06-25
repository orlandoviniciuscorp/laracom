<?php

namespace App\Shop\CategoryShopLocalizations\Repositories;

use App\Shop\CategoryShopLocalizations\CategoryShopLocalization;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Shop\CategoryShopLocalizations\Repositories\Interfaces\CategoryShopLocalizationRepositoryInterface;

class CategoryShopLocalizationRepository extends BaseRepository implements CategoryShopLocalizationRepositoryInterface
{
	/**
     * CategoryShopLocalizationRepository constructor.
     * 
     * @param CategoryShopLocalization $dummy
     */
    public function __construct(CategoryShopLocalization $dummy)
    {
        parent::__construct($dummy);
        $this->model = $dummy;
    }

    /**
     * List all the CategoryShopLocalizations
     *
     * @param string $order
     * @param string $sort
     * @param array $except
     * @return \Illuminate\Support\Collection
     */
    public function listCategoryShopLocalizations(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * Create CategoryShopLocalization
     *
     * @param array $params
     *
     * @return CategoryShopLocalization
     * @throws InvalidArgumentException
     */
    public function createCategoryShopLocalization(array $params) : CategoryShopLocalization
    {
        try {
        	return CategoryShopLocalization::create($params);
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the dummy
     *
     * @param array $params
     * @return CategoryShopLocalization
     */
    public function updateCategoryShopLocalization(array $params) : CategoryShopLocalization
    {
        $dummy = $this->findCategoryShopLocalizationById($this->model->id);
        $dummy->update($params);
        return $dummy;
    }

    /**
     * @param int $id
     * 
     * @return CategoryShopLocalization
     * @throws ModelNotFoundException
     */
    public function findCategoryShopLocalizationById(int $id) : CategoryShopLocalization
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
    public function deleteCategoryShopLocalization() : bool
    {
        return $this->model->delete();
    }
}