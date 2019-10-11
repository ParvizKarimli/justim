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
        $active_user_ids = Activity::users()->select('user_id')->get()->pluck('user_id')->toArray();

        $threads = 'Some threads';

        return view
        (
            'pages.index',
            [
                'threads' => $threads,
                'active_user_ids' => $active_user_ids
            ]
        );
    }
}
