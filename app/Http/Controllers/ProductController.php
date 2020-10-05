<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, Commerce $commerce)
    {
        //! no se porque arroja error
        //return Product::commerce($commerce)->with(['subrubro.rubro'])->get();

        return Product::with(['subrubro.rubro'])->whereCommerceId($commerce->id)->get();
    }

    public function show(Request $request, Commerce $commerce, Product $product)
    {
        //! no se porque arroja error
        //return Product::commerce($commerce)->with(['subrubro.rubro'])->get();

        return Product::with(['subrubro.rubro'])->whereCommerceId($commerce->id)->find($product->id);
    }
}
