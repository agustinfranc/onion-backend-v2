<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommerceBranches extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'fullname', 'address', 'whatsapp_number', 'phone_number', 'maps_account'];

    /**
     * Relationships
     */

    public function commerce()
    {
        return $this->belongsTo(Commerce::class);
    }
}