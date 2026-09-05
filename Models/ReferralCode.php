<?php

namespace Modules\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Spine\Traits\HasLifecycleHooks;

class ReferralCode extends Model
{
    use HasLifecycleHooks;

    protected $table = 'referral_codes';

    protected $fillable = [
        'user_id', 'code', 'is_active',
        'terms_accepted_at', 'terms_version',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    public static function labels(): array
    {
        return [
            'user_id'            => 'User',
            'code'               => 'Kode',
            'is_active'          => 'Aktif',
            'terms_accepted_at'  => 'T&C Diterima',
            'terms_version'      => 'Versi T&C',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}