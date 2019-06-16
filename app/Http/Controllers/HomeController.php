<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use EventManagement\Announcement;
use EventManagement\Activity;
use EventManagement\Event;

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
                'Events' => '/events',
                'Activities' => '/activities',
                'Announcements' => '/announcements',
                'Mayor Schedules' => '/mayorschedules',
            ),

            array (
                'Rental Spaces' => '/rentalspaces',
                'Rental Area Types' => '/rentalareatypes',
            ),

            array (
                'Salary Grades' => '/salarygrades',
                'Attendances' => '/attendances',
                'Deduction Types' => '/deductiontypes',
                'Employee Active Deductions' => '/activedeductions',
                'Monthly Payouts' => '/monthlypayouts'
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
            ->orderBy('created_at', 'DESC')
            ->get();

        $events = Event::with('activities')
            ->where('status', 'active')
            ->orderBy('startdate', 'ASC')
            ->whereHas('activities', function($query){
                $query->orderBy('schedule', 'ASC');
            })
            ->get();

        return view('welcome', compact('announcements', 'events'));
    }
}
