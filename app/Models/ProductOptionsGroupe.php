<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOptionsGroupe extends Model
{
    use SoftDeletes, HasFactory;

    public function product_options()
    {
        return $this->hasMany(ProductOption::class);
    }
}
