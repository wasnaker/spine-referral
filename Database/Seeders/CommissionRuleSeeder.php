<?php

namespace Modules\Referral\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Referral\Models\CommissionRule;

/**
 * Aturan komisi default (contoh). Idempotent by name.
 */
class CommissionRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            ['name' => 'Komisi 10%',         'type' => 'percentage', 'value' => 10],
            ['name' => 'Komisi Flat Rp25rb', 'type' => 'fixed',      'value' => 25000],
        ];

        foreach ($rules as $r) {
            CommissionRule::updateOrCreate(
                ['name' => $r['name']],
                ['type' => $r['type'], 'value' => $r['value'], 'is_active' => true]
            );
        }
    }
}