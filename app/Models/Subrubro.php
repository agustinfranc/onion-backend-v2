<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subrubro extends Model
{
    use SoftDeletes;

    /**
     * Relationships
     */

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function rubro()
    {
        return $this->belongsTo('App\Models\Rubro');
    }

    public function commerces()
    {
        return $this->belongsToMany('App\Models\Commerce');
    }

    /**
     * Scopes
     */

    /**
     * Scope a query to only include certain commerce.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCommerce($query, $commerceName)
    {
        $commerce = Commerce::whereName($commerceName)->first();

        return $query->where('commerce_id', '=', $commerce->id);
    }
}