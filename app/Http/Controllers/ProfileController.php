<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // guard: frontend (FrontendUser)

class ProfileController extends Controller
{
    // GET /profile
    public function edit()
    {
        $user = Auth::guard('frontend')->user();
        return view('profile.edit', compact('user'));
    }

    // PATCH /profile  (minimal: ism-familya-telefon parolsiz)
    public function update(Request $request)
    {
        $user = Auth::guard('frontend')->user();

        // hozircha validationsiz
        $user->name       = (string) $request->input('name', $user->name);
        $user->lastname   = (string) $request->input('lastname', $user->lastname);
        $user->middlename = (string) $request->input('middlename', $user->middlename);
        $user->email      = (string) $request->input('email', $user->email);
        $user->phone_e164 = (string) $request->input('phone', $user->phone_e164);
        $user->save();

        return request()->wantsJson()
            ? response()->json(['ok' => true, 'message' => 'Yangilandi'])
            : back()->with('status', 'Yangilandi');
    }

    // (ixtiyoriy) DELETE /profile — akkauntni o‘chirish
    public function destroy(Request $request)
    {
        $user = Auth::guard('frontend')->user();
        Auth::guard('frontend')->logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
