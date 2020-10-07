<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Scopes
     */

    /**
     * Scope a query to only include commerces by authenticated user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query)
    {
        return $query->whereHas('users', function (Builder $query) {
            $query->whereId(Auth::user()->id);
        });
    }

}
