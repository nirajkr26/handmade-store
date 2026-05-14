<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSeller()) {
            // Get orders where the seller's products are involved
            $orders = Order::whereHas('items.product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['items.product', 'buyer'])->latest()->get();
            
            return view('orders.index', compact('orders'));
        }

        // For buyers, get orders they placed
        $orders = $user->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $order = DB::transaction(function () use ($request, $product) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $product->price * $request->quantity,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);

            // Reduce stock
            $product->decrement('stock', $request->quantity);

            return $order;
        });

        // Send confirmation email
        Mail::to($request->user())->send(new OrderPlaced($order));

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function update(Request $request, Order $order)
    {
        // Ensure user is the seller of at least one item in the order
        // In this simplified model, we check if the user is a seller
        if (!Auth::user()->isSeller()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated to ' . $request->status . '.');
    }

    public function destroy(Order $order)
    {
        // Ensure user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        DB::transaction(function () use ($order) {
            // Restore stock for each item
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Update order status to cancelled
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Order cancelled successfully and stock restored.');
    }
}
