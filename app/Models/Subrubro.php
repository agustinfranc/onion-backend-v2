<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subrubro extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * Relationships
     */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function commerces()
    {
        return $this->belongsToMany(Commerce::class)->withPivot('slideable');
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