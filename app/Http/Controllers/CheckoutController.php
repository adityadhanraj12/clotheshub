<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UsersAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('customer-login')
                ->with('error', 'Please login first.');
        }
        $carts = Cart::with('product')
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhere('session_id', session()->getId());
            })
            ->get();
        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }
        $invoice = UsersAddress::where('user_id', $userId)
            ->where('address_type', 'invoice')
            ->first();

        $shipping = null;
        if (session('different_shipping')) {
            $shipping = UsersAddress::where('user_id', $userId)
                ->where('address_type', 'shipping')
                ->first();
        }
        DB::beginTransaction();
        $subtotal = 0;
        foreach ($carts as $cart) {
            $subtotal += ($cart->product->base_price ?? 0) * $cart->quantity;
        }
        $shippingCost = $subtotal * 0.02;
        $tax = $subtotal * 0.10;
        $total = $subtotal + $shippingCost + $tax;

        $order = Order::create([
            'order_id' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => $userId,
            'status' => 'pending',
            'delivery_method' => session('delivery_method'),
            'payment_method' => session('payment_method'),
            'total_price' => $total,
            'user_invoice_address' => $invoice ? $invoice->toArray() : null,
            'user_shipping_address' => $shipping ? $shipping->toArray() : null,
        ]);
        $order->update([
            'total_price' => $total
        ]);
        foreach ($carts as $cart) {

            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,

            ]);

        }
        Cart::where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
                ->orWhere('session_id', session()->getId());
        })->delete();
        DB::commit();
        return redirect()->route('order.success')
            ->with('success', 'Order placed successfully');
    }
    public function saveDeliveryMethod(Request $request)
    {
        session([
            'delivery_method' => $request->delivery_method
        ]);

        return redirect()->route('checkout3');
    }
    public function savePaymentMethod(Request $request)
    {
        session([
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('checkout4');
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }
}