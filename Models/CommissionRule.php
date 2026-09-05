<?php

namespace Modules\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionRule extends Model
{
    protected $table = 'commission_rules';

    protected $fillable = [
        'name',
        'type',
        'value',
        'is_active',
    ];

    protected $casts = [
        'value'     => 'decimal:2',
        'is_active' => 'boolean',
    ];
}