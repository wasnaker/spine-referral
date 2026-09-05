<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_codes', function (Blueprint $table) {
            $table->id();

            // Pemilik kode = user login (staff modul mana pun atau referrer murni).
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('code', 20)->unique();   // kode referral tampil ke publik
            $table->boolean('is_active')->default(true);
            $table->timestamp('terms_accepted_at')->nullable(); // T&C disetujui saat generate
            $table->string('terms_version', 20)->nullable();

            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('referrer_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('referred_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('referral_code_id')
                ->constrained('referral_codes')
                ->cascadeOnDelete();

            // registered / converted / expired — komisi menyusul di fase berikutnya.
            $table->string('status', 20)->default('registered');
            $table->timestamp('registered_at');

            $table->timestamps();

            $table->unique(['referral_code_id', 'referred_id']);
        });

        Schema::create('commission_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 20);        // percentage | fixed
            $table->decimal('value', 12, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_rules');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('referral_codes');
    }
};