<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommerceBranchOrderTimeOption extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'fullname', 'address', 'whatsapp_number', 'phone_number', 'maps_account'];

    protected $hidden = ['deleted_at'];

    protected $casts = [
        'takeaway' => 'boolean',
        'disabled' => 'boolean',
    ];

    /**
     * Relationships
     */

    public function commerce_branch()
    {
        return $this->belongsTo(CommerceBranch::class);
    }
}
