<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use EventManagement\Announcement;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return view('home');
        } else {
            return redirect('welcome');
        }
    }

    public function welcome()
    {
        $announcements = Announcement::where('active', true)->get();
        return view('welcome', compact('announcements'));
    }
}
