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
        $friends = auth()->user()->getFriends($perPage = 10);

        return view
        (
            'pages.index',
            [
                'friends' => $friends
            ]
        );
    }
}
