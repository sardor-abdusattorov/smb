<?php

// app/Http/Controllers/Auth/PhoneAuthController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FrontendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PhoneAuthController extends Controller
{
    public function requestCode(Request $request)
    {
        $raw = (string) $request->input('phone', '');
        // normalize (FrontendUser mutators ham ishlaydi)
        $tmp = new FrontendUser();
        $tmp->phone_e164 = $raw;
        $phone = $tmp->phone_e164;

        $user = FrontendUser::where('phone_e164', $phone)->first();
        if (!$user) {
            // avtomatik ro‘yxatdan o‘tkazish (xohlasangiz o‘chiring)
            $user = FrontendUser::create([
                'name'       => 'User '.Str::random(6),
                'phone_e164' => $phone,
                'password'   => Hash::make(Str::random(12)),
                'is_active'  => true,
            ]);
        }

        $code = (string) random_int(100000, 999999);
        $user->otp_code_hash  = Hash::make($code);
        $user->otp_expires_at = now()->addMinutes(5);
        $user->otp_attempts   = 0;
        $user->save();

        // TODO: haqiqiy SMS yuborish (hozircha log/placeholder)
        logger()->info("SMS to {$user->phone_e164}: {$code}");

        return response()->json(['ok' => true, 'message' => 'Kod yuborildi']);
    }

    public function verifyCode(Request $request)
    {
        $raw  = (string) $request->input('phone', '');
        $code = (string) $request->input('code', '');

        $tmp = new FrontendUser();
        $tmp->phone_e164 = $raw;
        $phone = $tmp->phone_e164;

        $user = FrontendUser::where('phone_e164', $phone)->first();
        if (!$user || !$user->otp_code_hash || !$user->otp_expires_at) {
            return response()->json(['ok' => false, 'message' => 'Kod so‘ralmagan'], 422);
        }
        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['ok' => false, 'message' => 'Kod muddati tugagan'], 422);
        }
        if ($user->otp_attempts >= 5) {
            return response()->json(['ok' => false, 'message' => 'Ko‘p urinish'], 429);
        }

        $user->otp_attempts += 1;
        $user->save();

        if (!Hash::check($code, $user->otp_code_hash)) {
            return response()->json(['ok' => false, 'message' => 'Kod noto‘g‘ri'], 422);
        }

        // success
        $user->otp_code_hash  = null;
        $user->otp_expires_at = null;
        $user->otp_attempts   = 0;
        $user->phone_verified_at = now();
        $user->save();

        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        return response()->json(['ok' => true, 'redirect' => route('profile.edit')]);
    }
}
