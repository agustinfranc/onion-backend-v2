<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommerceBranch extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'fullname', 'address', 'whatsapp_number', 'phone_number', 'maps_account'];

    protected $hidden = ['mp_access_token', 'deleted_at'];

    protected $casts = [
        'mp_enabled' => 'boolean',
        'has_delivery' => 'boolean',
        'has_takeaway' => 'boolean',
    ];

    /**
     * Relationships
     */

    public function commerce()
    {
        return $this->belongsTo(Commerce::class);
    }

    public function commerce_branch_order_time_options()
    {
        return $this->hasMany(CommerceBranchOrderTimeOption::class);
    }
}
