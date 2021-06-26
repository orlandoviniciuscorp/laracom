<?php

namespace App\Shop\ShopLocalizations\Repositories\Interfaces;

use App\Shop\ShopLocalizations\ShopLocalization;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepositoryInterface;

interface ShopLocalizationRepositoryInterface extends BaseRepositoryInterface
{
    public function listShopLocalizations(string $order = 'id', string $sort = 'desc', $except = []) : Collection;

    public function createShopLocalization(array $params) : ShopLocalization;

    public function updateShopLocalization(array $params) : ShopLocalization;

    public function findShopLocalizationById(int $id) : ShopLocalization;
    
    public function deleteShopLocalization() : bool;
}
