<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Activity;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $friends = auth()->user()->getFriends();

        $online_friends_ids = Activity::users(1)
            ->join('friendships', function ($join) {
                $join->on('sessions.user_id', '=', 'friendships.sender_id')
                    ->orOn('sessions.user_id', '=', 'friendships.recipient_id');
            })
            ->where('sessions.user_id', '!=', auth()->id())
            ->pluck('user_id')
            ->toArray();

        return view
        (
            'pages.index',
            [
                'friends' => $friends,
                'online_friends_ids' => $online_friends_ids
            ]
        );
    }
}
