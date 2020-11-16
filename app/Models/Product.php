<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'name', 'price', 'subrubro_id', 'description'];

    /**
     * Relationships
     */

    public function subrubro()
    {
        return $this->belongsTo('App\Models\Subrubro');
    }

    public function commerce()
    {
        return $this->belongsTo('App\Models\Commerce');
    }

    public function product_hashtags()
    {
        return $this->hasMany('App\Models\ProductHashtag');
    }

    public function product_prices()
    {
        return $this->hasMany('App\Models\ProductPrice');
    }

    /**
     * Scopes
     */

    /**
     * Scope a query to only include certain commerce.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCommerce($query, Commerce $commerce)
    {
        return $query->where('commerce_id', '=', $commerce->id);
    }

    /**
     * Scope a query to only include certain commerce by authenticated user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCommerceByUser($query)
    {
        //return $query->where('commerce_id', '=', $commerce->id);
    }
}