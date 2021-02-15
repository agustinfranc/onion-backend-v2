<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommerceSubrubro extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commerce_subrubro';

    protected $fillable = ['slideable'];

    /**
     * Relationships
     */

    public function subrubro()
    {
        return $this->belongsTo(Subrubro::class);
    }

}
