<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Rubro extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * Relationships
     */

    public function subrubros()
    {
        return $this->hasMany('App\Models\Subrubro');
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