<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageReceived;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Simplified approach: Get unique users we have chatted with
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($message) use ($user) {
                return $message->sender_id == $user->id ? $message->receiver : $message->sender;
            })
            ->unique('id');

        $activeUser = null;
        $activeMessages = collect();

        if ($request->has('user')) {
            $activeUser = User::find($request->user);
            if ($activeUser) {
                $activeMessages = Message::where(function($q) use ($user, $activeUser) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $activeUser->id);
                    })
                    ->orWhere(function($q) use ($user, $activeUser) {
                        $q->where('sender_id', $activeUser->id)->where('receiver_id', $user->id);
                    })
                    ->with(['sender', 'receiver'])
                    ->oldest() // Sort for chat view
                    ->get();
            }
        }

        return view('messages.index', compact('conversations', 'activeUser', 'activeMessages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Send notification email to receiver
        $receiver = User::find($request->receiver_id);
        Mail::to($receiver)->send(new NewMessageReceived($msg));

        return back()->with('success', 'Message sent successfully!');
    }
}
