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
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
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
}
