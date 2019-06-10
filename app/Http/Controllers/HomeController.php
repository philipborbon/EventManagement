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
        $links = array (
            'Users' => '/users',
            'Events' => '/events',
            'Salary Grades' => '/salarygrades',
            'Deduction Types' => '/deductiontypes',
            'Rental Spaces' => '/rentalspaces',
            'Rental Area Types' => '/rentalareatypes',
            'Activities' => '/activities',
            'Document Types' => '/documenttypes',
            'Announcements' => '/announcements',
            'Mayor Schedules' => '/mayorschedules',
            'User Identifications' => '/useridentifications'
        );


        if (Auth::check()) {
            return view('home', compact('links'));
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
