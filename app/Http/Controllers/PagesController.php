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

        $active_user_ids = Activity::users(1)
            ->select('user_id')
            ->get()
            ->pluck('user_id')
            ->toArray();

        return view
        (
            'pages.index',
            [
                'friends' => $friends,
                'active_user_ids' => $active_user_ids
            ]
        );
    }
}
