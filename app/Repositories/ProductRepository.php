<?php

namespace App\Repositories;

use App\Models\Commerce;
use App\Models\Product;

class ProductRepository
{
    public function getAll(Commerce $commerce)
    {
        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->whereCommerceId($commerce->id)->get();
    }

    public function getOne(Product $product)
    {
        return $product->load(['subrubro.rubro', 'product_hashtags', 'product_prices']);
    }
}