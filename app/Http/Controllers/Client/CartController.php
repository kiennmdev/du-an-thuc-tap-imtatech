<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function list()
    {
        // session()->forget('cart');
        if (session('cart')) {
            $this->calTotalPriceAndQuantity();
        }

        return view('client.cart');
    }

    public function add()
    {
        // dd(request()->toArray());
        $productVariant = ProductVariant::query()->with('color', 'size', 'product')->where(
            [
                'product_id' => request('product_id'),
                'product_color_id' => request('color_id'),
                'product_size_id' => request('size_id'),
            ]
        )->firstOrFail();

        if (!isset(session('cart')[$productVariant->id])) {
            $data = $productVariant->toArray() + ['quantity_purchase' => request('quantity')];
            session()->put('cart.' . $productVariant->id, $data);
        } else {
            $data = session('cart')[$productVariant->id];
            $data['quantity_purchase'] = request('quantity');
            session()->put('cart.' . $productVariant->id, $data);
        }
        // dd(session('cart'));
        return redirect()->route('cart.list');
    }

    public function update()
    {

        $newQuantity = request()->product_variant;
        $data = session('cart');

        foreach ($newQuantity as $idProductVariant => $quantity) {
            if ($quantity <= 0) {
                $quantity = 1;
            }
            foreach ($data as $id => $item) {
                if ($id === $idProductVariant) {
                    $data[$id]['quantity_purchase'] = $quantity;
                }
            }
        }

        session()->put('cart', $data);

        return back();
    }

    public function destroy(string $id)
    {
        $data = session('cart');
        unset($data[$id]);
        session()->put('cart', $data);

        $this->calTotalPriceAndQuantity();

        return back();
    }

    public function calTotalPriceAndQuantity()
    {
        $cart = session('cart');

        $totalAmount = 0;

        foreach ($cart as $item) {
            $totalAmount += $item['quantity_purchase'] * ($item['price_sale'] ?: $item['price_regular']);
        }

        session()->put('total_amount', $totalAmount);
    }
}
