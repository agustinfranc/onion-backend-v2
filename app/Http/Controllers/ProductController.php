<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Commerce;
use App\Models\Product;
use App\Models\ProductHashtag;
use App\Models\ProductPrice;
use App\Models\Rubro;
use App\Models\Subrubro;
use App\Repositories\ProductRepository;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Commerce $commerce, ProductRepository $repository)
    {
        return $repository->getAll($commerce);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product, ProductRepository $repository)
    {
        return $repository->getOne($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Commerce $commerce, ProductRepository $repository)
    {
        $codeRules = [Rule::unique('products')->where(function ($query) use ($commerce) {
            return $query
                ->where('commerce_id', $commerce->id)
                ->whereNotNull('code');
        })];

        $validatedData = $request->validate([
            'code' => $codeRules,
        ]);

        $validatedData = array_merge($request->all(), $validatedData);

        $product = $repository->save($validatedData, $commerce);

        return $product->load(['subrubro.rubro', 'product_hashtags', 'product_prices']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product, ProductRepository $repository)
    {
        $codeRules = [Rule::unique('products')->where(function ($query) use ($product) {
            return $query
                ->where('commerce_id', $product->commerce_id)
                ->whereNotNull('code');
        })->ignore($product)];

        $validatedData = $request->validate([
            'code' => $codeRules,
        ]);

        $validatedData = array_merge($request->all(), $validatedData);

        DB::beginTransaction();

        $product = $repository->update($validatedData, $product);

        DB::commit();

        return $product->load(['subrubro.rubro', 'product_hashtags', 'product_prices']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductRepository $repository)
    {
        return response($repository->delete($product));
    }

    /**
     * Upload a product image/avatar to storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Product $product)
    {
        // todo: create request to validate it (size, extension...)

        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return response()->json(['error' => 'No se encontó una imagen o la imagen no es válida'], 500);
        }

        $path = $request->file('image')->store('images', 'public');

        // $product->avatar_dirname = env('APP_URL', 'https://api.onion.ar') . '/storage/' . $path;
        $product->avatar_dirname = 'https://api.onion.ar/storage/' . $path;
        $product->avatar = '';

        $product->save();

        return response($product);
    }
}
