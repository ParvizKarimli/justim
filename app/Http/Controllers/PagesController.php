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
        $friend_requests = auth()->user()->getFriendRequests();
        //dd(count($friend_requests));
        /*if(count($friend_requests) === 0)
        {
            dd('no friend requests');
        }
        else
        {
            dd($friend_requests[0]->name);
        }*/

        return view
        (
            'pages.index',
            [
                'friends' => $friends,
                'friend_requests' => $friend_requests
            ]
        );
    }
}
