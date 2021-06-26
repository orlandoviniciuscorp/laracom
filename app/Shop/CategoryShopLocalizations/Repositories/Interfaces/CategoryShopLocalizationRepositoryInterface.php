<?php

namespace App\Shop\CategoryShopLocalizations\Repositories\Interfaces;

use App\Shop\CategoryShopLocalizations\CategoryShopLocalization;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepositoryInterface;

interface CategoryShopLocalizationRepositoryInterface extends BaseRepositoryInterface
{
    public function listCategoryShopLocalizations(string $order = 'id', string $sort = 'desc', $except = []) : Collection;

    public function createCategoryShopLocalization(array $params) : CategoryShopLocalization;

    public function updateCategoryShopLocalization(array $params) : CategoryShopLocalization;

    public function findCategoryShopLocalizationById(int $id) : CategoryShopLocalization;
    
    public function deleteCategoryShopLocalization() : bool;
}
