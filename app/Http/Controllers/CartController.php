<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    /* ================== AUTH (DB) ================== */

    public function add(Request $request) {

        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color'      => 'nullable|string|max:64',
            'size'       => 'nullable|string|max:64',
            'material'   => 'nullable|string|max:64',
            'qty'        => 'nullable|integer|min:1|max:999',
        ]);

        $userId = Auth::id();
        $qty = (int)($data['qty'] ?? 1);

        $item = CartItem::firstOrNew([
            'frontend_user_id' => $userId,
            'product_id'       => (int)$data['product_id'],
            'color'            => $data['color'] ?? null,
            'size'             => $data['size'] ?? null,
            'material'         => $data['material'] ?? null,
        ]);
        $item->quantity = max(1, (int)$item->quantity + $qty);
        $item->save();

        return response()->json(['ok'=>true, 'qty'=>$item->quantity, 'count'=>$this->dbCount($userId)]);
    }

    public function set(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color'      => 'nullable|string|max:64',
            'size'       => 'nullable|string|max:64',
            'material'   => 'nullable|string|max:64',
            'qty'        => 'required|integer|min:1|max:999',
        ]);
        $userId = Auth::id();

        $item = CartItem::updateOrCreate([
            'frontend_user_id' => $userId,
            'product_id'       => (int)$data['product_id'],
            'color'            => $data['color'] ?? null,
            'size'             => $data['size'] ?? null,
            'material'         => $data['material'] ?? null,
        ], [
            'quantity' => (int)$data['qty'],
        ]);

        return response()->json(['ok'=>true, 'qty'=>$item->quantity, 'count'=>$this->dbCount($userId)]);
    }

    public function remove(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color'      => 'nullable|string|max:64',
            'size'       => 'nullable|string|max:64',
            'material'   => 'nullable|string|max:64',
        ]);
        $userId = Auth::id();

        CartItem::where('frontend_user_id',$userId)
            ->where('product_id',(int)$data['product_id'])
            ->where('color', $data['color'] ?? null)
            ->where('size',  $data['size'] ?? null)
            ->where('material', $data['material'] ?? null)
            ->delete();

        return response()->json(['ok'=>true, 'count'=>$this->dbCount($userId)]);
    }

    public function clear() {
        CartItem::where('frontend_user_id', Auth::id())->delete();
        return response()->json(['ok'=>true, 'count'=>0]);
    }

    private function dbCount($userId) {
        return (int) CartItem::where('frontend_user_id',$userId)->sum('quantity');
    }

    /* ================== GUEST (SESSION) ================== */

    private function keyFrom($pid,$color,$size,$material) {
        return implode('|', [
            (int)$pid,
            (string)($color ?? ''),
            (string)($size ?? ''),
            (string)($material ?? ''),
        ]);
    }
    private function getGuestCart(): array {
        $cart = session('guest_cart');
        if (!$cart || !isset($cart['created_at'])) {
            return ['items'=>[], 'created_at'=>now()->toDateTimeString()];
        }
        if (Carbon::parse($cart['created_at'])->lt(now()->subDays(7))) {
            return ['items'=>[], 'created_at'=>now()->toDateTimeString()];
        }
        return $cart;
    }
    private function saveGuestCart(array $data): void {
        session(['guest_cart'=>$data]);
    }
    private function guestCount(array $cart): int {
        $sum = 0;
        foreach ($cart['items'] ?? [] as $row) $sum += (int)($row['qty'] ?? 0);
        return $sum;
    }

    public function guestAdd(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color'      => 'nullable|string|max:64',
            'size'       => 'nullable|string|max:64',
            'material'   => 'nullable|string|max:64',
            'qty'        => 'nullable|integer|min:1|max:999',
        ]);
        $pid = (int)$data['product_id'];
        $qty = (int)($data['qty'] ?? 1);

        $cart = $this->getGuestCart();
        $key  = $this->keyFrom($pid, $data['color'] ?? null, $data['size'] ?? null, $data['material'] ?? null);

        $row = $cart['items'][$key] ?? [
            'product_id'=>$pid,
            'color'=>$data['color'] ?? null,
            'size'=>$data['size'] ?? null,
            'material'=>$data['material'] ?? null,
            'qty'=>0
        ];
        $row['qty'] = max(1, (int)$row['qty'] + $qty);
        $cart['items'][$key] = $row;

        $this->saveGuestCart($cart);
        return response()->json(['ok'=>true, 'qty'=>$row['qty'], 'count'=>$this->guestCount($cart)]);
    }

    public function guestSet(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color'      => 'nullable|string|max:64',
            'size'       => 'nullable|string|max:64',
            'material'   => 'nullable|string|max:64',
            'qty'        => 'required|integer|min:1|max:999',
        ]);
        $pid = (int)$data['product_id'];

        $cart = $this->getGuestCart();
        $key  = $this->keyFrom($pid, $data['color'] ?? null, $data['size'] ?? null, $data['material'] ?? null);
        $cart['items'][$key] = [
            'product_id'=>$pid,
            'color'=>$data['color'] ?? null,
            'size'=>$data['size'] ?? null,
            'material'=>$data['material'] ?? null,
            'qty'=>(int)$data['qty'],
        ];
        $this->saveGuestCart($cart);
        return response()->json(['ok'=>true, 'qty'=>$cart['items'][$key]['qty'], 'count'=>$this->guestCount($cart)]);
    }

    public function guestRemove(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'color'      => 'nullable|string|max:64',
            'size'       => 'nullable|string|max:64',
            'material'   => 'nullable|string|max:64',
        ]);
        $pid = (int)$data['product_id'];

        $cart = $this->getGuestCart();
        $key  = $this->keyFrom($pid, $data['color'] ?? null, $data['size'] ?? null, $data['material'] ?? null);
        unset($cart['items'][$key]);
        $this->saveGuestCart($cart);

        return response()->json(['ok'=>true, 'count'=>$this->guestCount($cart)]);
    }

    /* ===== MERGE (register/login dan keyin) session -> DB ===== */
    public static function migrateGuestCartToUser(int $userId): int {
        $cart = session('guest_cart', null);
        if (!$cart || empty($cart['items'])) return 0;

        $affected = 0;
        foreach ($cart['items'] as $row) {
            $qty = (int)($row['qty'] ?? 0);
            if ($qty < 1) continue;

            $item = CartItem::firstOrNew([
                'frontend_user_id' => $userId,
                'product_id'       => (int)$row['product_id'],
                'color'            => $row['color'] ?? null,
                'size'             => $row['size'] ?? null,
                'material'         => $row['material'] ?? null,
            ]);
            $item->quantity = max(1, (int)$item->quantity + $qty);
            $item->save();
            $affected++;
        }
        session()->forget('guest_cart');
        return $affected;
    }


public function mini()
{
    // Auth bo‘lsa — DB dan
    if (auth('frontend')->check()) {
        $userId = auth('frontend')->id();

        $items = \App\Models\CartItem::with([
                'product',
                'product.category',
                'product.subcategory',
                'product.variants',
            ])
            ->where('frontend_user_id', $userId)
            ->get()
            ->filter(fn($row) => $row->product) // product o‘chirilgan bo‘lsa tashlab yuboramiz
            ->values();

        $lines = $items->map(function ($row) {
            $p = $row->product;
            $unit = (float)($p->price ?? 0);
            $old  = (float)($p->old_price ?? 0);
            $qty  = (int)$row->quantity;

            return [
                'product_id' => $p->id,
                'name'       => $p->name,
                'slug'       => $p->slug,
                'category'   => $p->category?->slug,
                'subcategory'=> $p->subcategory?->slug,
                'image'      => $p->getFirstMediaUrl('preview_image') ?: '/images/placeholder.png',
                'color'      => $row->color,
                'size'       => $row->size,
                'material'   => $row->material,
                'qty'        => $qty,
                'unit_price' => $unit,
                'old_price'  => $old,
                'line_total' => $unit * $qty,
            ];
        });

        $count  = (int)$items->sum('quantity');
        $total  = (float)$lines->sum('line_total');

        return view('partials.cart_modal_body', [
            'count'  => $count,
            'total'  => $total,
            'lines'  => $lines,
            'isAuth' => true,
        ]);
    }

    // Guest — sessiondan
    $cart = session('guest_cart');
    $map  = $cart['items'] ?? []; // ["pid|color|size|material" => ['product_id'=>..,'color'=>..,'size'=>..,'material'=>..,'qty'=>..]]

    if (empty($map)) {
        return view('partials.cart_modal_body', [
            'count'  => 0,
            'total'  => 0,
            'lines'  => collect(),
            'isAuth' => false,
        ]);
    }

    $ids = array_unique(array_map(fn($r) => (int)$r['product_id'], $map));
    $productsById = \App\Models\Product::with(['category','subcategory','variants'])
        ->whereIn('id', $ids)->get()->keyBy('id');

    $lines = collect();
    $count = 0;
    $total = 0;

    foreach ($map as $row) {
        $p = $productsById[$row['product_id']] ?? null;
        if (!$p) continue;

        $qty  = (int)($row['qty'] ?? 1);
        $unit = (float)($p->price ?? 0);
        $old  = (float)($p->old_price ?? 0);

        $lines->push([
            'product_id' => $p->id,
            'name'       => $p->name,
            'slug'       => $p->slug,
            'category'   => $p->category?->slug,
            'subcategory'=> $p->subcategory?->slug,
            'image'      => $p->getFirstMediaUrl('preview_image') ?: '/images/placeholder.png',
            'color'      => $row['color'] ?? null,
            'size'       => $row['size'] ?? null,
            'material'   => $row['material'] ?? null,
            'qty'        => $qty,
            'unit_price' => $unit,
            'old_price'  => $old,
            'line_total' => $unit * $qty,
        ]);

        $count += $qty;
        $total += $unit * $qty;
    }

    return view('partials.cart_modal_body', [
        'count'  => $count,
        'total'  => $total,
        'lines'  => $lines,
        'isAuth' => false,
    ]);
}

}
