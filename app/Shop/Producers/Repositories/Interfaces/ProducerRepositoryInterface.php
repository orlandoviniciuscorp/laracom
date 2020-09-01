<?php

namespace App\Shop\Producers\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Producers\Producer;
use App\Shop\Products\Product;
use Illuminate\Support\Collection;

interface ProducerRepositoryInterface extends BaseRepositoryInterface
{
    public function listProducers(string $order = 'id', string $sort = 'desc', $except = []) : Collection;

    public function createProducer(array $params) : Producer;

    public function updateProducer(array $params) : Producer;

    public function findProducerById(int $id) : Producer;

    public function deleteProducer() : bool;

    public function associateProduct(Product $product);

    public function findProducts() : Collection;

    public function syncProducts(array $params);

    public function detachProducts();

    public function deleteFile(array $file, $disk = null) : bool;

    public function findProducerBySlug(array $slug) : Producer;

    public function rootProducers(string $string, string $string1);
}
