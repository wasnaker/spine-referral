<?php

namespace Modules\Referral\Database\Seeders;

use Illuminate\Database\Seeder;

class ReferralCodeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('referral_codes')->delete();
        
        \DB::table('referral_codes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 44444,
                'code' => '642A48',
                'is_active' => 1,
                'terms_accepted_at' => '2026-09-09 02:21:11',
                'terms_version' => '1.0',
                'created_at' => '2026-09-09 02:21:11',
                'updated_at' => '2026-09-09 02:21:11',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 10249,
                'code' => 'LXJZXK',
                'is_active' => 1,
                'terms_accepted_at' => '2026-09-09 02:31:26',
                'terms_version' => '1.0',
                'created_at' => '2026-09-09 02:31:26',
                'updated_at' => '2026-09-09 02:31:26',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 44445,
                'code' => '37D389',
                'is_active' => 1,
                'terms_accepted_at' => '2026-09-09 02:41:10',
                'terms_version' => '1.0',
                'created_at' => '2026-09-09 02:41:10',
                'updated_at' => '2026-09-09 02:41:10',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 44446,
                'code' => '9289E6',
                'is_active' => 1,
                'terms_accepted_at' => '2026-09-09 02:41:10',
                'terms_version' => '1.0',
                'created_at' => '2026-09-09 02:41:10',
                'updated_at' => '2026-09-09 02:41:10',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 44447,
                'code' => 'ECB220',
                'is_active' => 1,
                'terms_accepted_at' => '2026-09-09 02:41:10',
                'terms_version' => '1.0',
                'created_at' => '2026-09-09 02:41:10',
                'updated_at' => '2026-09-09 02:41:10',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 44448,
                'code' => '92ED96',
                'is_active' => 1,
                'terms_accepted_at' => '2026-09-09 02:41:10',
                'terms_version' => '1.0',
                'created_at' => '2026-09-09 02:41:10',
                'updated_at' => '2026-09-09 02:41:10',
            ),
        ));
        
        
    }
}