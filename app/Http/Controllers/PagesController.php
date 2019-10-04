<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        session(['nightmode' => 0]);
    }

    public function index()
    {
        $threads = 'Some threads';

        return view('pages.index', ['threads' => $threads]);
    }

    public function nightmode(Request $request)
    {
        if(session('nightmode') == 0)
        {
            session(['nightmode' => 1]);

            return back()
                ->with(
                    'success',
                    'Night mode switched on for the current session only. If you want to make it persistent with your account, then go to Settings > Appearance > Turn On/Off Lights.'
                );
        }
        else
        {
            session(['nightmode' => 0]);

            return back()
                ->with(
                    'success',
                    'Night mode switched off for the current session only. If you want to make it persistent with your account, then go to Settings > Appearance > Turn On/Off Lights.'
                );
        }
    }
}
