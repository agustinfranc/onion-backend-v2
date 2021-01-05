<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Product;
use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'code' => ['required', Rule::unique('products')->where(function ($query) use ($commerce) {
                return $query->where('commerce_id', $commerce->id);
            })],
            'name' => 'required|max:255',
            'rubro_id' => 'required|exists:rubros,id',
            'subrubro_id' => 'sometimes|required|exists:subrubros,id',
            'price' => '',
            'subrubro' => '',
            'description' => 'max:255',
        ]);

        $product = new Product();

        $rubro = Rubro::find($validatedData['rubro_id']);

        if (!array_key_exists('subrubro_id', $validatedData)) {

            $subrubro = new Subrubro();
            $subrubro->name = $validatedData['subrubro'];

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

        return response()->json($product);
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
        $validatedData = $request->validate([
            'code' => ['required', Rule::unique('products')->where(function ($query) use ($product) {
                return $query->where('commerce_id', $product->commerce_id);
            })],
            'name' => 'required|max:255',
            'subrubro.id' => 'required|exists:subrubros,id',
            'price' => '',
            'description' => 'max:255',
            'disabled' => 'boolean',
        ]);

        $subrubro = Subrubro::find($validatedData['subrubro']['id']);
        $rubroId = $subrubro->rubro->id;

        $commerce = Commerce::find($product->commerce_id);

        $commerce->rubros()->syncWithoutDetaching($rubroId);
        $commerce->subrubros()->syncWithoutDetaching($validatedData['subrubro']['id']);

        $product->fill($validatedData);

        $product->save();

        return response($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response(true);
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

        logger($path);

        $product->avatar_dirname = env('APP_URL') . '/storage/' . $path;
        $product->avatar = '';

        $product->save();

        return response($product);
    }
}
