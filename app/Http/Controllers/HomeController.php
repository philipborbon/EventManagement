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
            array (
                'Users' => '/users',
                'User Identifications' => '/useridentifications',
                'Document Types' => '/documenttypes',
            ),

            array (
                'Salary Grades' => '/salarygrades',
                'Deduction Types' => '/deductiontypes'
            ),

            array (
                'Events' => '/events',
                'Activities' => '/activities',
                'Announcements' => '/announcements',
                'Mayor Schedules' => '/mayorschedules',
            ),

            array (
                'Rental Spaces' => '/rentalspaces',
                'Rental Area Types' => '/rentalareatypes',
            )
        );


        if (Auth::check()) {
            return view('home', compact('links'));
        } else {
            return redirect('welcome');
        }
    }

    public function welcome()
    {
        $announcements = Announcement::where('active', true)
            ->orderBy('created_at', '')
            ->get();
        return view('welcome', compact('announcements'));
    }
}
