<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FrontendUser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Http\Controllers\WishlistController;

class AjaxAuthController extends Controller
{
    public function login(Request $request)
    {
        // Email + parol (modal login uchun)
        $email    = (string) $request->input('email', '');
        $password = (string) $request->input('password', '');
        $remember = (bool) $request->boolean('remember', false);

        if (Auth::guard('frontend')->attempt(['email' => $email, 'password' => $password, 'is_active' => 1], $remember)) {
            $request->session()->regenerate();
            return response()->json(['ok' => true, 'redirect' => route('profile.edit')]);
        }
        return response()->json(['ok' => false, 'message' => 'Неверный email или пароль'], 401);
    }

    public function register(Request $request)
    {
        $email = trim((string) $request->input('email'));
        $phone = trim((string) $request->input('phone'));
        $password = (string) $request->input('password');
        $confirm  = (string) $request->input('password_confirmation');

        // 1️⃣ Parollarni tekshirish
        if (strlen($password) < 6) {
            return response()->json([
                'ok' => false,
                'message' => 'Пароль должен содержать не менее 6 символов.'
            ], 422);
        }

        if ($password !== $confirm) {
            return response()->json([
                'ok' => false,
                'message' => 'Пароли не совпадают. Повторите попытку.'
            ], 422);
        }

        // 2️⃣ Email va telefon unikal bo‘lishi kerak
        if (FrontendUser::where('email', $email)->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Этот e-mail уже зарегистрирован.'
            ], 422);
        }

        if (FrontendUser::where('phone_e164', $phone)->exists()) {
            return response()->json([
                'ok' => false,
                'message' => 'Этот номер телефона уже зарегистрирован.'
            ], 422);
        }

        // 3️⃣ Yaratish (xatolik bo‘lsa — QueryException)
        try {
            $user = new FrontendUser();
            $user->name       = (string) $request->input('name');
            $user->lastname   = (string) $request->input('lastname');
            $user->middlename = (string) $request->input('middlename');
            $user->email      = $email;
            $user->phone_e164 = $phone;
            $user->password   = Hash::make($password);
            $user->is_active  = true;
            $user->save();
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Такой e-mail или номер телефона уже существует.'
                ], 422);
            }
            return response()->json([
                'ok' => false,
                'message' => 'Ошибка при сохранении данных.'
            ], 500);
        }

        // 4️⃣ Login va redirect
        Auth::guard('frontend')->login($user);
        WishlistController::migrateGuestWishlistToUser($user->id);
        $request->session()->regenerate();

        return response()->json([
            'ok' => true,
            'redirect' => route('profile.edit'),
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('frontend')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['ok' => true, 'redirect' => url('/')]);
    }
}
