<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('frontend_users', function (Blueprint $table) {
            $table->id();

            // FIO
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('middlename')->nullable();

            // Kontaktlar
            $table->string('email')->nullable()->unique();        // email login uchun (ixtiyoriy)
            $table->string('phone_e164', 20)->nullable()->unique(); // telefon OTP uchun (ixtiyoriy)

            // Email-login uchun parol (telefon-OTP bo‘lsa ham bo‘lishi mumkin)
            $table->string('password')->nullable();

            // Telefon verifikatsiyasi (OTP orqali)
            $table->timestamp('phone_verified_at')->nullable();

            // OTP uchun
            $table->string('otp_code_hash')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->unsignedTinyInteger('otp_attempts')->default(0);

            // Holat
            $table->boolean('is_active')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('frontend_users');
    }
};
