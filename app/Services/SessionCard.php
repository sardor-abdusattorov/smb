<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionCart
{
    protected string $key = 'cart';

    protected function getCart(Request $request): array
    {
        return $request->session()->get($this->key, ['items' => []]);
    }

    protected function putCart(Request $request, array $cart): void
    {
        $request->session()->put($this->key, $cart);
    }

    public function add(Request $request, int $productId, int $qty = 1): array
    {
        $qty = max(1, $qty);
        $cart = $this->getCart($request);

        $product = Product::findOrFail($productId);
        $price = (int) $product->price; // kerak bo'lsa discount ni qo'ying

        if (!isset($cart['items'][$productId])) {
            $cart['items'][$productId] = ['qty' => 0, 'price' => $price];
        }

        $cart['items'][$productId]['qty'] += $qty;
        // snapshot price yangilashni xohlasez:
        $cart['items'][$productId]['price'] = $price;

        $this->putCart($request, $cart);
        return $this->summary($request);
    }

    public function updateQty(Request $request, int $productId, int $qty): array
    {
        $cart = $this->getCart($request);
        if (!isset($cart['items'][$productId])) {
            return $this->summary($request);
        }
        if ($qty <= 0) {
            unset($cart['items'][$productId]);
        } else {
            $cart['items'][$productId]['qty'] = $qty;
        }
        $this->putCart($request, $cart);
        return $this->summary($request);
    }

    public function remove(Request $request, int $productId): array
    {
        $cart = $this->getCart($request);
        unset($cart['items'][$productId]);
        $this->putCart($request, $cart);
        return $this->summary($request);
    }

    public function clear(Request $request): void
    {
        $this->putCart($request, ['items' => []]);
    }

    public function count(Request $request): int
    {
        $cart = $this->getCart($request);
        return array_sum(array_column($cart['items'], 'qty'));
    }

    public function total(Request $request): int
    {
        $cart = $this->getCart($request);
        $total = 0;
        foreach ($cart['items'] as $row) {
            $total += (int)$row['qty'] * (int)$row['price'];
        }
        return $total;
    }

    public function items(Request $request): array
    {
        return $this->getCart($request)['items'];
    }

    public function summary(Request $request): array
    {
        return [
            'count' => $this->count($request),
            'total' => $this->total($request),
            'items' => $this->items($request),
        ];
    }
}
