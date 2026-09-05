<?php

declare(strict_types=1);

namespace Modules\Referral\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Referral\Models\ReferralCode;
use Modules\Referral\Models\Referral;
use Modules\Referral\Models\CommissionRule;

/**
 * Referral — kode referral + relasi + aturan komisi.
 *
 * Alur generate (keputusan user): kode TIDAK digenerate massal. Staff mana pun
 * (customer/surveyor/agency/association) atau referrer murni membuat kode via
 * form: POST /referral-codes dengan accept_terms=true -> user resmi referrer.
 */
class ReferralController extends Controller
{
    /**
     * Daftar kode referral (admin: semua; staff: miliknya).
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $codes = ReferralCode::with('user:id,name,email')
            ->when(! $user->can('referral:manage'), fn ($q) => $q->where('user_id', $user->id))
            ->orderByDesc('id')
            ->get();

        return response()->json(['data' => $codes]);
    }

    /**
     * Generate kode referral utk user login (wajib setujui T&C).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'accept_terms' => ['required', 'boolean', 'accepted'],
        ]);

        $user = $request->user();

        // 1 user = maks 1 kode aktif.
        if (ReferralCode::where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Anda sudah memiliki kode referral.'], 422);
        }

        $code = Str::upper(Str::random(6));

        // Jamin unik (kolom unique + retry).
        while (ReferralCode::where('code', $code)->exists()) {
            $code = Str::upper(Str::random(6));
        }

        $referralCode = ReferralCode::create([
            'user_id'           => $user->id,
            'code'              => $code,
            'is_active'         => true,
            'terms_accepted_at' => now(),
            'terms_version'     => '1.0',
        ]);

        return response()->json(['data' => $referralCode], 201);
    }

    /**
     * Nonaktifkan/aktifkan kode.
     */
    public function toggle(Request $request, int $id): JsonResponse
    {
        $code = ReferralCode::find($id);

        if (! $code) {
            return response()->json(['message' => 'Code not found'], 404);
        }

        if (! $request->user()->can('referral:manage') && $code->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $code->update(['is_active' => ! $code->is_active]);

        return response()->json(['data' => $code]);
    }

    /**
     * Relasi referral (siapa ajak siapa). Admin: semua; staff: miliknya.
     * ?code_id=X membatasi ke satu kode.
     */
    public function referrals(Request $request): JsonResponse
    {
        $user = $request->user();

        $referrals = Referral::with(['referrer:id,name,email', 'referred:id,name,email', 'code:id,code'])
            ->when($request->integer('code_id'), fn ($q, $codeId) => $q->where('referral_code_id', $codeId))
            ->when(! $user->can('referral:manage'), fn ($q) => $q->where('referrer_id', $user->id))
            ->orderByDesc('id')
            ->get();

        return response()->json(['data' => $referrals]);
    }

    /**
     * Aturan komisi.
     */
    public function rules(): JsonResponse
    {
        return response()->json(['data' => CommissionRule::orderBy('id')->get()]);
    }
}