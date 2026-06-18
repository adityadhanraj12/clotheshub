<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('customerLogin')->with('error', 'Please login first.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);
        $product = Product::findOrFail($request->product_id);
        $cart = Cart::where('product_id', $product->id)
            ->where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->orWhere('session_id', session()->getId());
            })
            ->first();

        $currentQuantity = $cart ? $cart->quantity : 0;
        if ($currentQuantity + $request->quantity > 100) {
            return redirect()->back()->withInput()->withErrors([
                'quantity' => "You can only order a maximum of 100 quantities per product. You already have {$currentQuantity} in your cart."
            ]);
        }

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->back()
            ->with('success', 'Product added to cart!');
    }
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('customerLogin')->with('error', 'Please login first.');
        }

        $carts = Cart::with('product')
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('session_id', session()->getId());
            })
            ->get();
        $subtotal = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->base_price;
        });
        return view('cart', compact('carts', 'subtotal'));
    }
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();

        return back()->with('success', 'Item removed from cart.');
    }
    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1|max:100',
        ], [
            'quantities.*.max' => 'You can only order a maximum of 100 quantities per product.'
        ]);

        foreach ($request->quantities as $cartId => $quantity) {
            $cart = Cart::find($cartId);
            if ($cart && $quantity > 0) {
                $cart->update([
                    'quantity' => $quantity
                ]);
            }
        }
        return back()->with('success', 'Cart updated successfully.');
    }
}