<?php

namespace Modules\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Spine\Traits\HasLifecycleHooks;

class Referral extends Model
{
    use HasLifecycleHooks;

    protected $table = 'referrals';

    protected $fillable = [
        'referrer_id', 'referred_id', 'referral_code_id',
        'status', 'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public static function labels(): array
    {
        return [
            'referrer_id'      => 'Pengirim',
            'referred_id'      => 'Direferensikan',
            'referral_code_id' => 'Kode Referral',
            'status'           => 'Status',
            'registered_at'    => 'Tanggal Registrasi',
        ];
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function code(): BelongsTo
    {
        return $this->belongsTo(ReferralCode::class, 'referral_code_id');
    }
}