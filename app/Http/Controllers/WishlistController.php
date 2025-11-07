<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);
        $user = Auth::guard('web')->user();
        $pid  = (int) $request->input('product_id');

        // bazada mavjudligini tekshirish
        $exists = WishlistItem::where('frontend_user_id', $user->id)
                              ->where('product_id', $pid)
                              ->exists();

        if ($exists) {
            WishlistItem::where('frontend_user_id', $user->id)
                        ->where('product_id', $pid)
                        ->delete();
            $active = false;
        } else {
            WishlistItem::create([
                'frontend_user_id' => $user->id,
                'product_id'       => $pid,
            ]);
            $active = true;
        }

        return response()->json(['ok' => true, 'active' => $active]);
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);
        $user = Auth::guard('web')->user();
        $user->wishlistProducts()->syncWithoutDetaching([(int)$request->product_id]);

        return response()->json(['ok' => true]);
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);
        $user = Auth::guard('web')->user();
        $user->wishlistProducts()->detach((int)$request->product_id);

        return response()->json(['ok' => true]);
    }

    public function guestToggle(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);
        $pid = (int) $request->product_id;

        $key = 'guest_wishlist';
        $data = session($key, null);

        // Yangi sessiya yoki eskirgan sessiyani qayta yaratish
        if (!$data || !isset($data['created_at'])) {
            $data = [
                'items' => [],
                'created_at' => now()->toDateTimeString(),
            ];
        } else {
            $created = Carbon::parse($data['created_at']);
            if ($created->lt(now()->subDays(7))) {
                // eskirgan — yangisiga o'zgartiramiz
                $data = [
                    'items' => [],
                    'created_at' => now()->toDateTimeString(),
                ];
            }
        }

        $items = (array) ($data['items'] ?? []);

        if (in_array($pid, $items)) {
            // o'chirish
            $items = array_values(array_diff($items, [$pid]));
            $active = false;
        } else {
            // qo'shish (uniq saqlaymiz)
            $items[] = $pid;
            $items = array_values(array_unique($items));
            $active = true;
        }

        $data['items'] = $items;
        session([$key => $data]);

        return response()->json(['ok' => true, 'active' => $active, 'count' => count($items)]);
    }

    /**
     * Sessiondagi guest wishlistni qaytaradi (agar 7 kun ichida bo'lsa).
     * Aks holda sessiyani tozalaydi va [] qaytaradi.
     */
    public static function getGuestWishlistFromSession()
    {
        $key = 'guest_wishlist';
        $data = session($key, null);
        if (!$data || !isset($data['created_at'])) return [];
        $created = Carbon::parse($data['created_at']);
        if ($created->lt(now()->subDays(7))) {
            session()->forget($key);
            return [];
        }
        return isset($data['items']) ? (array)$data['items'] : [];
    }

    /**
     * Register qilinganidan so'ng chaqiriladi:
     * sessiondagi itemlarni DB ga migrate qiladi va sessionni tozalaydi.
     */
    public static function migrateGuestWishlistToUser($userId)
    {
        $items = self::getGuestWishlistFromSession(); // array of product_id
        if (empty($items)) return 0;

        $now = now()->toDateTimeString();

        $rows = [];
        foreach ($items as $pid) {
            $rows[] = [
                'frontend_user_id' => $userId,
                'product_id' => $pid,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // insertOrIgnore — duplicate'larni chetlab o'tadi
        DB::table('wishlist_items')->insertOrIgnore($rows);

        // sessiyani tozalaymiz
        session()->forget('guest_wishlist');

        return count($rows);
    }
}
