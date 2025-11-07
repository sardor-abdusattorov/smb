<?php

// app/Models/FrontendUser.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FrontendUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'frontend_users';

    protected $fillable = [
        'name','lastname','middlename',
        'email','phone_e164','password',
        'phone_verified_at',
        'otp_code_hash','otp_expires_at','otp_attempts',
        'is_active',
    ];

    protected $hidden = ['password','remember_token','otp_code_hash'];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'is_active'         => 'boolean',
    ];

    // E.164 normalizatsiya (sodda)
    protected function phoneE164(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (!$value) return null;
                $digits = preg_replace('/\D+/', '', (string)$value);
                if ($digits && !str_starts_with($digits, '998')) {
                    $digits = '998'.$digits; // agar asosiy auditoriya O'zbekiston bo'lsa
                }
                return '+'.$digits;
            }
        );
    }

    // app/Models/FrontendUser.php
    public function wishlistProducts()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'wishlist_items', 'frontend_user_id', 'product_id')
                    ->withTimestamps();
    }

    // app/Models/Product.php
    public function wishlistedBy()
    {
        return $this->belongsToMany(\App\Models\FrontendUser::class, 'wishlist_items', 'product_id', 'frontend_user_id')
                    ->withTimestamps();
    }

}
