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
            ->orderBy('friendships.id', 'desc')
            ->paginate(10);

        $friend_requests_count = count(auth()->user()->getFriendRequests());

        /**
         * Hootlex has default getBlockedFriendships() method
         * to get the list of blocked users
         * but it uses get() instead of paginate($perPage) in the end
         * which is not what I want.
         * Also I need the friendships table to be joined with
         * the users table to get used data e.g. names, usernames etc.
         * And I don't want to edit the Friendable trait file
         * to modify the default method.
         */
        $blocked_users = \DB::table('friendships')
            ->where('friendships.sender_id', auth()->id())
            ->where('friendships.status', 3)
            ->join('users', 'users.id', '=', 'friendships.recipient_id')
            ->select('users.id', 'users.username')
            ->paginate(10);

        // Get user notifications
        $notifications = auth()->user()->notifications;
        /*$notifications = \DB::table('notifications')
            ->where('notifications.notifiable_id', '=', auth()->id())
            ->select(
                'id',
                'data',
                'created_at',
                'read_at'
            )
        ->paginate(10);*/
        //dd($notifications);

        // Get the number of notifications
        $number_of_notifications = \DB::table('notifications')
            ->where('notifiable_id', '=', auth()->id())
            ->count();

        return view
        (
            'pages.index',
            [
                'friends' => $friends,
                'friend_requests' => $friend_requests,
                'friend_requests_count' => $friend_requests_count,
                'blocked_users' => $blocked_users,
                'notifications' => $notifications,
                'number_of_notifications' => $number_of_notifications,
            ]
        );
    }
}
