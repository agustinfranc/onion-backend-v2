<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductHashtag extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'to'];

    /**
     * Relationships
     */

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}