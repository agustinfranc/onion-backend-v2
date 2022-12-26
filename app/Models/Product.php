<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['code', 'name', 'price', 'description', 'disabled', 'avatar', 'avatar_dirname'];

    protected $hidden = ['deleted_at'];

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

    public function product_options_groupes()
    {
        return $this->hasMany(ProductOptionsGroupe::class);
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
}
