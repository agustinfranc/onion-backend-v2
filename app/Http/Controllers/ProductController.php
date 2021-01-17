<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Product;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Commerce $commerce)
    {
        $codeRules = $request->code ? [Rule::unique('products')->where(function ($query) use ($commerce) {
            return $query->where('commerce_id', $commerce->id);
        })] : '';

        $validatedData = $request->validate([
            'code' => $codeRules,
            'name' => 'required|max:255',
            'rubro_id' => 'required|exists:rubros,id',
            'subrubro_id' => 'sometimes|required|exists:subrubros,id',
            'price' => '',
            'subrubro' => '',
            'description' => 'max:255',
        ]);

        $product = new Product();

        if (!array_key_exists('subrubro_id', $validatedData)) {

            $subrubro = new Subrubro();
            $subrubro->name = $validatedData['subrubro'];

            $rubro = Rubro::find($validatedData['rubro_id']);

            $subrubro->rubro()->associate($rubro);

            $subrubro->save();
        } else {
            $subrubro = Subrubro::find($validatedData['subrubro_id']);
        }

        $subrubroId = $subrubro->id;

        $product->subrubro()->associate($subrubro);

        $commerce->rubros()->syncWithoutDetaching($validatedData['rubro_id']);
        $commerce->subrubros()->syncWithoutDetaching($subrubroId);

        $product->fill($validatedData);

        $product->commerce()->associate($commerce);

        $product->save();

        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->find($product->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $codeRules = $request->code ? [Rule::unique('products')->where(function ($query) use ($product) {
            return $query->where('commerce_id', $product->commerce_id);
        })->ignore($product)] : '';

        $validatedData = $request->validate([
            'code' => $codeRules,
            'description' => 'max:255',
            'disabled' => 'boolean',
            'name' => 'required|max:255',
            'price' => '',
            'product_prices' => 'array',
            'rubro.id' => 'required|exists:rubros,id',
            'subrubro.id' => 'sometimes|required|exists:subrubros,id',
            'subrubro' => '',
        ]);

        DB::beginTransaction();

        if (isset($validatedData['subrubro']['id'])) {

            $product->subrubro()->associate($validatedData['subrubro']['id']);
        } else {
            $product->subrubro()->dissociate();

            $subrubro = new Subrubro();
            $subrubro->name = $validatedData['subrubro'];

            $rubro = Rubro::find($validatedData['rubro']['id']);

            $subrubro->rubro()->associate($rubro);

            $subrubro->save();

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

        if (isset($validatedData['product_prices'])) {

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
        }


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
            return;
        }

        $path = $request->file('image')->store('images', 'public');

        $product->avatar_dirname = env('APP_URL') . '/storage/' . $path;
        $product->avatar = '';

        $product->save();

        return response($product);
    }
}
