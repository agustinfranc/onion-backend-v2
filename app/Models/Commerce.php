<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Commerce extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'fullname', 'cover_dirname', 'avatar_dirname', 'whatsapp_number', 'instagram_account', 'has_action_buttons', 'has_footer'];

    /**
     * Relationships
     */

    public function rubros()
    {
        return $this->belongsToMany('App\Models\Rubro')->withPivot(['sort', 'highlighted']);
    }

    public function subrubros()
    {
        return $this->belongsToMany('App\Models\Subrubro');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
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
    public function scopeOfUser($query, $userId = null)
    {
        if (!$userId && request()->user()) $userId = request()->user()->id;

        return $query->whereHas('users', function (Builder $query) use ($userId) {
            $query->whereId($userId);
        });
    }

}
