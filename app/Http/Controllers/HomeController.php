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
        $user = Auth::user();

        $links = NULL;

        if ($user) {
            if ($user->usertype == 'admin') {
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
                        'Mayor\'s Schedules' => '/mayorschedules',
                    ),

                    array (
                        'Rental Spaces' => '/rentalspaces',
                        'Rental Area Types' => '/rentalareatypes',
                        'Rental Payments' => '/payments',
                        'Reservations' => '/reservations'
                    ),

                    array (
                        'Salary Grades' => '/salarygrades',
                        'Attendances' => '/attendances',
                        'Deduction Types' => '/deductiontypes',
                        'Employee Active Deductions' => '/activedeductions',
                        'Payslip' => '/payslips'
                    ),

                    array (
                        'Financial Report' => '/financialreport'
                    )
                );
            } else if ($user->usertype == 'employee'){
                $links = array (
                    array (
                        'Document Types' => '/documenttypes'
                    ),

                    array (
                        'Events' => '/events',
                        'Activities' => '/activities',
                        'Announcements' => '/announcements',
                        'Mayor\'s Schedules' => '/mayorschedules',
                    ),

                    array (
                        'Rental Spaces' => '/rentalspaces',
                        'Rental Area Types' => '/rentalareatypes',
                        'Rental Payments' => '/payments',
                        'Reservations' => '/reservations'
                    ),

                    array (
                        'Attendances' => '/attendances',
                        'Employee Active Deductions' => '/activedeductions',
                        'Payslip' => '/payslips'
                    ),

                    array (
                        'Financial Report' => '/financialreport'
                    )
                );
            }
        }

        if (Auth::check()) {
            if ($user->usertype == 'participant') {
                return redirect('events/register');
            } else if ($user->usertype == 'investor') {
                return redirect('rentaspace');
            } else {
                return view('home', compact('links'));
            }
        } else {
            return redirect('welcome');
        }
    }

    public function welcome()
    {
        $announcements = Announcement::where('active', true)
            ->orderBy('created_at', 'DESC')
            ->get();

        $events = Event::where('status', 'active')
            ->orderBy('startdate', 'ASC')
            ->whereHas('activities')
            ->get();

        return view('welcome', compact('announcements', 'events'));
    }
}
