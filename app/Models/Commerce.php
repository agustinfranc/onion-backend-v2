<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Commerce extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'fullname', 'cover_dirname', 'avatar_dirname', 'whatsapp_number', 'phone_number' ,'instagram_account', 'facebook_account', 'youtube_account', 'tiktok_account', 'maps_account', 'dark_theme', 'has_action_buttons', 'has_footer'];

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

    // Sucursales
    public function branches()
    {
        return $this->hasMany(CommerceBranch::class);
    }

    /**
     * Scopes
     */

    /**
     * Scope a query to only include commerces by authenticated user
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $user = null)
    {
        if (!$user && request()->user()) $user = request()->user();

        return $query->when(!$user->admin, function ($query) use ($user) {
            return $query->whereHas('users', function (Builder $query) use ($user) {
                $query->whereId($user->id);
            });
        });
    }
}
