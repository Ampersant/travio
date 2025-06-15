<?php

namespace App\Http\Controllers;

use App\Events\FriendRequestResponded;
use App\Events\FriendRequestSent;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function index()
    {
        $meId = Auth::id();

        $users = User::where('id', '!=', $meId)
            ->whereDoesntHave('sentFriendRequests', function ($q) use ($meId) {
                $q->where('receiver_id', $meId);
            })
            ->whereDoesntHave('receivedFriendRequests', function ($q) use ($meId) {
                $q->where('sender_id', $meId);
            })
            ->get();
        return view('connections', compact('users'));
    }

    public function sendRequest(Request $request)
    {
        $senderId = auth()->id();
        $receiverId = $request->input('receiver_id');

        $friendship = Friendship::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);
        event(new FriendRequestSent($friendship));
        return response()->json(['message' => 'Request sent successfully']);
    }
    public function respondRequest(Request $request)
    {
        $friendship = Friendship::findOrFail($request->input('friendship_id'));

        if ($friendship->receiver_id !== auth()->id()) {
            abort(403);
        }

        $friendship->status = $request->input('status');
        $friendship->save();
        event(new FriendRequestResponded($friendship));
        return response()->json(['message' => 'Response recorded', 'status' => $friendship->status]);
    }
    public function allFriends(Request $request)
    {
        $user = $request->user();
        $friends = $user->acceptedFriends()->map(function ($u) {
            return [
                'id'    => $u->id,
                'name'  => $u->name,
                'email' => $u->email,
            ];
        });
        return response()->json($friends);
    }
}
