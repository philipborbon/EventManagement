<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;

use EventManagement\Announcement;
use EventManagement\Event;
use EventManagement\EventParticipant;

use Auth;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('status', 'active')
            ->orderBy('startdate', 'ASC')
            ->whereHas('activities')
            ->get();

        $user = Auth::user();

        return view('participant.index', compact('user', 'events', 'activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function register(Request $request)
    {
        $register = $this->validate(request(), [
            'userid' => 'required|integer',
            'activityid' => 'required|integer'
        ]);

        // TODO: create event participant record

        return redirect('events/register')->with('success', 'Registration has been submitted.');
    }
}
