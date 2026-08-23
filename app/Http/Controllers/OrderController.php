<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkoutForm(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();

        abort_if($cartItems->isEmpty(), 404, 'Keranjangmu masih kosong.');

        $total = $cartItems->sum(fn ($item) => $item->subtotal());

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $cartItems = $request->user()->cartItems()->with('product')->get();

        abort_if($cartItems->isEmpty(), 404, 'Keranjangmu masih kosong.');

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->withErrors([
                    'stock' => 'Stok '.$item->product->name.' tidak mencukupi.',
                ]);
            }
        }

        $order = DB::transaction(function () use ($request, $cartItems) {
            $total = $cartItems->sum(fn ($item) => $item->subtotal());

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'total' => $total,
                'recipient_name' => $request->recipient_name,
                'phone' => $request->phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal(),
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $request->user()->cartItems()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('status', 'Pesanan berhasil dibuat! Terima kasih, Bunny.');
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load('items');

        return view('orders.show', compact('order'));
    }
}
