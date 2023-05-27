<?php

namespace App\Repositories;

use App\Models\Commerce;
use App\Models\Product;
use App\Models\ProductHashtag;
use App\Models\ProductPrice;
use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getAll(Commerce $commerce): Collection
    {
        return Product::with(['subrubro.rubro', 'product_hashtags', 'product_prices'])->whereCommerceId($commerce->id)->get();
    }

    public function getOne(Product $product): Product
    {
        return $product->load(['subrubro.rubro', 'product_hashtags', 'product_prices', 'product_options_groupes.product_options']);
    }

    public function save(array $input, Commerce $commerce): Product
    {
        $product = new Product();

        if (!array_key_exists('subrubro_id', $input)) {

            // Busco subrubro por si ya existe
            $subrubro = Subrubro::where('name', $input['subrubro'])->first();

            if (!$subrubro) {
                $subrubro = new Subrubro();
                $subrubro->name = $input['subrubro'];

                $rubro = Rubro::find($input['rubro']['id']);

                $subrubro->rubro()->associate($rubro);

                $subrubro->save();
            }
        } else {
            $subrubro = Subrubro::find($input['subrubro_id']);
        }

        $subrubroId = $subrubro->id;

        $product->subrubro()->associate($subrubro);

        $commerce->rubros()->syncWithoutDetaching($subrubro->rubro->id);
        $commerce->subrubros()->syncWithoutDetaching($subrubroId);

        $product->fill($input);

        $product->commerce()->associate($commerce);

        $product->saveOrFail();

        $product = $this->_saveProductPrices($input, $product);

        $product = $this->_saveProductHashtags($input, $product);

        return $product->load(['subrubro.rubro', 'product_hashtags', 'product_prices']);
    }

    public function update(array $input, Product $product): Product
    {
        if (isset($input['subrubro']['id'])) {
            $product->subrubro()->associate($input['subrubro']['id']);
        } else {
            $product->subrubro()->dissociate();

            // Busco subrubro por si ya existe
            $subrubro = Subrubro::where('name', $input['subrubro'])->first();

            // Si no existe entonces lo creo
            if (!$subrubro) {
                $subrubro = new Subrubro();
                $subrubro->name = $input['subrubro'];

                $rubro = Rubro::find($input['rubro']['id']);

                $subrubro->rubro()->associate($rubro);

                $subrubro->save();
            }

            // Asocio el subrubro encontrado o creado
            $product->subrubro()->associate($subrubro);

            $product->saveOrFail();

            $product->refresh();
        }

        $commerce = Commerce::find($product->commerce_id);

        $commerce->rubros()->syncWithoutDetaching($product->subrubro->rubro->id);
        $commerce->subrubros()->syncWithoutDetaching($product->subrubro->id);

        $product->fill($input);

        $product->saveOrFail();

        $product = $this->_saveProductPrices($input, $product);

        $product = $this->_saveProductHashtags($input, $product);

        return $product->load(['subrubro.rubro', 'product_hashtags', 'product_prices']);
    }

    public function delete($product): bool
    {
        $product->code = null;

        $product->save();

        return $product->delete();
    }

    public function upload(array $input, Product $product): Product
    {
        $product->fill($input);

        $product->saveOrFail();

        return $product;
    }

    private function _saveProductPrices($input, Product $product): Product
    {
        // recorro product_prices de request
        // si tiene id lo busco y lo actualizo
        // si tiene id y la propiedad deleted_at existe lo busco y lo elimino
        // si no tiene id y no tiene deleted_at creo uno

        if (empty($input['product_prices'])) {
            return $product;
        }

        collect($input['product_prices'])->each(function ($validatedProductPrice) use ($product) {
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
                if (isset($validatedProductPrice['deleted_at'])) return;

                $productPrice = new ProductPrice();

                $productPrice->fill($validatedProductPrice);

                $product->product_prices()->save($productPrice);
            }
        });

        return $product;
    }

    private function _saveProductHashtags($input, Product $product): Product
    {
        // recorro product_hashtags de request
        // si tiene id lo busco y lo actualizo
        // si tiene id y la propiedad deleted_at existe lo busco y lo elimino
        // si no tiene id y no tiene deleted_at creo uno

        if (empty($input['product_hashtags'])) {
            return $product;
        }

        collect($input['product_hashtags'])->each(function ($validatedProductHashtag) use ($product) {
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
                if (isset($validatedProductHashtag['deleted_at'])) return;

                $productHashtag = new ProductHashtag();

                $productHashtag->fill($validatedProductHashtag);

                $product->product_hashtags()->save($productHashtag);
            }
        });

        return $product;
    }
}
