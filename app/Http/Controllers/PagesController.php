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

        $active_users_ids = Activity::users(1)
            ->select('user_id')
            ->get()
            ->pluck('user_id')
            ->toArray();

        return view
        (
            'pages.index',
            [
                'friends' => $friends,
                'active_users_ids' => $active_users_ids
            ]
        );
    }
}
