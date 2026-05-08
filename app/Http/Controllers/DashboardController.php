<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'recent_orders' => $user->orders()->latest()->take(5)->get(),
            'unread_messages' => Message::where('receiver_id', $user->id)->latest()->take(5)->get(),
        ];

        if ($user->isSeller()) {
            $stats['total_products'] = $user->products()->count();
            $stats['total_sales'] = Order::whereHas('items.product', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->sum('total_amount');
            $stats['my_products'] = $user->products()->latest()->take(5)->get();
        }

        return view('dashboard', compact('stats'));
    }
}
