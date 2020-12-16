<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
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

        //! metodo viejo
        /* $commerce->rubros = Commerce::find($commerce->id)->rubros()->orderBy('rubros.sort')->get();

        foreach ($commerce->rubros as $rubro) {
            $rubro->subrubros = Commerce::find($commerce->id)->subrubros()->where('subrubros.rubro_id', '=', $rubro->id)->orderBy('subrubros.sort')->get();

            foreach ($rubro->subrubros as $subrubro) {
                $subrubro->products = Product::with(['product_hashtags', 'product_prices'])->where([
                    ['subrubro_id', '=', $subrubro->id],
                    ['commerce_id', '=', $commerce->id],
                ])->get();
            }
        }

        return $commerce; */

        return Commerce::with(['rubros' => function (BelongsToMany $query) use ($commerce) {
                return $query->with(['subrubros' => function ($query) use ($commerce) {
                        return $query->with(['products' => function ($query) use ($commerce) {
                                return $query->where('commerce_id', $commerce->id);   // me trae los productos solo de ese comercio
                            }])
                            ->has('products')
                            ->whereHas('commerces', function ($query) use ($commerce) {
                                return $query->where('commerce_id', $commerce->id);   // me trae los subrubros solo de ese comercio
                            });
                    }])
                    ->where('commerce_id', $commerce->id);
            }])
            ->find($commerce->id);
    }
}
