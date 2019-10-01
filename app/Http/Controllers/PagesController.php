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
        $threads = 'Some threads';

        return view('pages.index', ['threads' => $threads]);
    }
}
