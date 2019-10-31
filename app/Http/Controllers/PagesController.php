<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $friends = auth()->user()->getFriends($perPage = 10);
        $friend_requests = \DB::table('friendships')
            ->join('users', 'users.id', '=', 'friendships.sender_id')
            ->where('friendships.recipient_id', auth()->id())
            ->where('friendships.status', 0)
            ->paginate(10);
        $friend_requests_count = count(auth()->user()->getFriendRequests());

        return view
        (
            'pages.index',
            [
                'friends' => $friends,
                'friend_requests' => $friend_requests,
                'friend_requests_count' => $friend_requests_count,
            ]
        );
    }
}
