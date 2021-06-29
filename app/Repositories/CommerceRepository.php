<?php

namespace App\Repositories;

use App\Models\Commerce;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CommerceRepository
{
    public function getByName(array $input, string $commerceName): Commerce
    {
        $commerce = Commerce::whereName($commerceName)->first();

        if (!$commerce) abort(404, 'No commerce found');

        if (isset($input['simplified']) && $input['simplified']) {
            return $commerce;
        }

        return $commerce->load(['currency', 'rubros' => function (BelongsToMany $query) use ($commerce) {
            return $query->with(['subrubros' => function (HasMany $query) use ($commerce) {
                return $query->with(['products' => function (HasMany $query) use ($commerce) {
                    return $query->with(['product_hashtags', 'product_prices'])->where('commerce_id', $commerce->id);   // me trae los productos solo de ese comercio
                }, 'commerces' => function (BelongsToMany $query) use ($commerce) {
                    return $query->where('id', $commerce->id);   // me trae la tabla pivot de commerces_subrubros
                }])
                    ->whereHas('commerces', function (Builder $query) use ($commerce) {
                        return $query->where('commerce_id', $commerce->id);   // me trae los subrubros solo de ese comercio
                    })
                    ->whereHas('products', function (Builder $query) use ($commerce) {
                        return $query->where('commerce_id', $commerce->id);
                    })
                    ->orderBy('sort');
            }])
                ->whereHas('subrubros', function (Builder $query) use ($commerce) {
                    return $query->whereHas('commerces', function (Builder $query) use ($commerce) {
                        return $query->where('commerce_id', $commerce->id);   // me trae los subrubros solo de ese comercio
                    })
                        ->whereHas('products', function (Builder $query) use ($commerce) {
                            return $query->where('commerce_id', $commerce->id);
                        });
                })
                ->where('commerce_id', $commerce->id)
                ->orderBy('sort');
        }]);
    }

    public function getAll(array $input, $user = null): Collection
    {
        if ($user) {
            return Commerce::ofUser($user)->get();
        }

        return Commerce::all();
    }

    public function getOne(Commerce $commerce, $user = null): Commerce
    {
        if (!$user) {
            return $commerce;
        }

        if (!$commerce->users->contains($user->id)) {
            abort(404, 'No commerce found for authenticated user');
        }

        return $commerce->load('currency');
    }

    public function save($input, $user): Commerce
    {
        $commerce = new Commerce();

        $input['name'] = Str::slug($input['fullname']);

        $commerce->currency()->associate($input['currency']['id']);
        $commerce->fill($input);

        $commerce->saveOrFail();

        $commerce->users()->syncWithoutDetaching($user->id);

        return $commerce;
    }

    public function update(array $input, Commerce $commerce): Commerce
    {
        $commerce->fill($input);

        $commerce->save();

        return $commerce;
    }
}