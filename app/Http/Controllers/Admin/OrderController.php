<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn ($q) => $q->where('order_number', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,completed,cancelled'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
        ]);

        $order->update($data);

        return back()->with('status', 'Status pesanan diperbarui.');
    }

    public function report(Request $request)
    {
        $month = $request->integer('month', now()->month);
        $year = $request->integer('year', now()->year);

        $orders = Order::with('items')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereIn('status', ['processing', 'shipped', 'completed'])
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();

        return view('admin.orders.report', compact('orders', 'totalRevenue', 'totalOrders', 'month', 'year'));
    }
}
