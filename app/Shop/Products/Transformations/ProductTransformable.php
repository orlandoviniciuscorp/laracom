<?php

namespace App\Shop\Products\Transformations;

use App\Shop\Products\Product;
use Illuminate\Support\Facades\Storage;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->description = $product->description;
        $prod->cover = $product->cover;
        $prod->quantity = $product->quantity;
        $prod->price = $product->price;
        $prod->status = $product->status;
        $prod->weight = (float) $product->weight;
        $prod->mass_unit = $product->mass_unit;
        $prod->sale_price = $product->sale_price;
        $prod->brand_id = (int) $product->brand_id;
        $prod->is_distinct = $product->is_distinct;
        $prod->percentage_id = (int)$product->percentage_id;
        $prod->producer_id = (int)$product->producer_id;
        $prod->is_in_promotion = $product->is_in_promotion;
        $prod->is_basket = $product->is_basket;
        $prod->shop_id = $product->shop_id;

        return $prod;
    }
}
