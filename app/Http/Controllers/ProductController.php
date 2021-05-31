<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Commerce;
use App\Models\Product;
use App\Models\ProductHashtag;
use App\Models\ProductPrice;
use App\Models\Rubro;
use App\Models\Subrubro;
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
    public function index(Request $request, Commerce $commerce)
    {
        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->whereCommerceId($commerce->id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->find($product->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Commerce $commerce)
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

        $product = new Product();

        if (!array_key_exists('subrubro_id', $validatedData)) {

            // Busco subrubro por si ya existe
            $subrubro = Subrubro::where('name', $validatedData['subrubro'])->first();

            if (!$subrubro) {
                $subrubro = new Subrubro();
                $subrubro->name = $validatedData['subrubro'];

                $rubro = Rubro::find($validatedData['rubro_id']);

                $subrubro->rubro()->associate($rubro);

                $subrubro->save();
            }
        } else {
            $subrubro = Subrubro::find($validatedData['subrubro_id']);
        }

        $subrubroId = $subrubro->id;

        $product->subrubro()->associate($subrubro);

        $commerce->rubros()->syncWithoutDetaching($validatedData['rubro_id']);
        $commerce->subrubros()->syncWithoutDetaching($subrubroId);

        $product->fill($validatedData);

        $product->commerce()->associate($commerce);

        $product->saveOrFail();

        $product = $this->_saveProductPrices($validatedData, $product);

        $product = $this->_saveProductHashtags($validatedData, $product);

        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->find($product->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
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

        if (isset($validatedData['subrubro']['id'])) {

            $product->subrubro()->associate($validatedData['subrubro']['id']);
        } else {
            $product->subrubro()->dissociate();

            // Busco subrubro por si ya existe
            $subrubro = Subrubro::where('name', $validatedData['subrubro'])->first();

            if (!$subrubro) {
                $subrubro = new Subrubro();
                $subrubro->name = $validatedData['subrubro'];

                $rubro = Rubro::find($validatedData['rubro']['id']);

                $subrubro->rubro()->associate($rubro);

                $subrubro->save();
            }

            $product->subrubro()->associate($subrubro);

            $product->saveOrFail();

            $product->refresh();
        }

        $rubroId = $product->subrubro->rubro->id;

        $commerce = Commerce::find($product->commerce_id);

        $commerce->rubros()->syncWithoutDetaching($rubroId);
        $commerce->subrubros()->syncWithoutDetaching($product->subrubro->id);

        $product->fill($validatedData);

        $product->saveOrFail();

        $product = $this->_saveProductPrices($validatedData, $product);

        $product = $this->_saveProductHashtags($validatedData, $product);

        DB::commit();

        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->find($product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->code = null;

        $product->save();

        return response($product->delete());
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

    private function _saveProductPrices($validatedData, Product $product): Product
    {
        // recorro product_prices de request
        // si tiene id lo busco y lo actualizo
        // si tiene id y la propiedad deleted_at existe lo busco y lo elimino
        // si no tiene id y no tiene deleted_at creo uno

        collect($validatedData['product_prices'])->each(function ($validatedProductPrice) use ($product) {
            if (isset($validatedProductPrice['id'])) {

                if (isset($validatedProductPrice['deleted_at'])) {
                    $productPrice = ProductPrice::find($validatedProductPrice['id']);

                    if ($productPrice) $productPrice->delete();
                } else {
                    $productPrice = ProductPrice::find($validatedProductPrice['id']);

                    $productPrice->fill($validatedProductPrice);

                    $productPrice->saveOrFail();
                }
            } else {
                $productPrice = new ProductPrice();

                $productPrice->fill($validatedProductPrice);

                $product->product_prices()->save($productPrice);
            }
        });

        return $product;
    }

    private function _saveProductHashtags($validatedData, Product $product): Product
    {
        // recorro product_hashtags de request
        // si tiene id lo busco y lo actualizo
        // si tiene id y la propiedad deleted_at existe lo busco y lo elimino
        // si no tiene id y no tiene deleted_at creo uno

        collect($validatedData['product_hashtags'])->each(function ($validatedProductHashtag) use ($product) {
            if (isset($validatedProductHashtag['id'])) {

                if (isset($validatedProductHashtag['deleted_at'])) {
                    $productHashtag = ProductHashtag::find($validatedProductHashtag['id']);

                    if ($productHashtag) $productHashtag->delete();
                } else {
                    $productHashtag = ProductHashtag::find($validatedProductHashtag['id']);

                    $productHashtag->fill($validatedProductHashtag);

                    $productHashtag->saveOrFail();
                }
            } else {
                $productHashtag = new ProductHashtag();

                $productHashtag->fill($validatedProductHashtag);

                $product->product_hashtags()->save($productHashtag);
            }
        });

        return $product;
    }

}
