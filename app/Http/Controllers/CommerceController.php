<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class CommerceController extends Controller
{
    /**
     * Get all the commerces or get the commerces for a given authenticated user.
     *
     * @param  Illuminate\Http\Request  $request
     * @return object response
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            return Commerce::ofUser($request->user()->id)->get();
        }

        return Commerce::all();
    }

    /**
     * Show the commerce for a given commerce name.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  string  $commerceName
     * @return object response
     */
    public function showByName(Request $request, $commerceName)
    {
        $commerce = Commerce::whereName($commerceName)->first();

        if (!$commerce) return response()->json('No commerce found');

        return Commerce::with(['currency', 'rubros' => function (BelongsToMany $query) use ($commerce) {
            return $query->with(['subrubros' => function (HasMany $query) use ($commerce) {
                return $query->with(['products' => function (HasMany $query) use ($commerce) {
                    return $query->with(['product_hashtags', 'product_prices'])->where('commerce_id', $commerce->id);   // me trae los productos solo de ese comercio
                }, 'commerces' => function (BelongsToMany $query) use ($commerce) {
                    return $query->where('id', $commerce->id);   // me trae la tabla pivot de commerces_subrubros
                }])
                    ->has('products')
                    ->whereHas('commerces', function (Builder $query) use ($commerce) {
                        return $query->where('commerce_id', $commerce->id);   // me trae los subrubros solo de ese comercio
                    })
                    ->orderBy('sort');
            }])
                ->orderBy('sort')
                ->where('commerce_id', $commerce->id);
        }])
            ->find($commerce->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commerce $commerce)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|max:255',
        ]);

        $commerce->fill($validatedData);

        $commerce->save();

        return $commerce;
    }

    /**
     * Upload commerce avatar/cover to storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Commerce $commerce)
    {
        // todo: create request to validate it (size, extension...)

        if (
            (!$request->hasFile('avatar') || !$request->file('avatar')->isValid()) &&
            (!$request->hasFile('cover')  || !$request->file('cover')->isValid())
        ) {
            return response()->json(['error' => 'No se encuentra imagen en la request'], 500);
        }

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->file('avatar')->store('images', 'public');

            $commerce->avatar_dirname = env('APP_URL') . '/storage/' . $path;
        }

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $path = $request->file('cover')->store('images', 'public');

            $commerce->cover_dirname = env('APP_URL') . '/storage/' . $path;
        }

        $commerce->save();

        return response($commerce);
    }
}
