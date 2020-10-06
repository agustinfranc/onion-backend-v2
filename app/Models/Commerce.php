<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commerce extends Model
{
    use SoftDeletes;

    /**
     * Relationships
     */
    public function rubros()
    {
        return $this->belongsToMany('App\Models\Rubro');
    }

    public function subrubros()
    {
        return $this->belongsToMany('App\Models\Subrubro');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

}
