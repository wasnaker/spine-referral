<?php

namespace Modules\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ReferralCode extends Model
{
    protected $table = 'referral_codes';

    protected $fillable = [
        'user_id',
        'code',
        'is_active',
        'terms_accepted_at',
        'terms_version',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}