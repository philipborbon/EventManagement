<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\Activity;
use EventManagement\Event;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::all();
        return view('activity.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::where('status', 'active')->get();
        return view('activity.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $this->validate(request(), [
            'eventid' => 'required|exists:events,id',
            'name' => 'required|string',
            'location' => 'required|string',
            'schedule' => 'required|date'
        ]);

        Activity::create($event);

        return back()->with('success', 'Activity has been added.');
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
        $activity = Activity::find($id);
        $events = Event::where('status', 'active')->get();
        return view('activity.edit', compact('id', 'activity', 'events'));
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
        $activity = Activity::find($id);

        $this->validate(request(), [
            'eventid' => 'required|exists:events,id',
            'name' => 'required|string',
            'location' => 'required|string',
            'schedule' => 'required|date'
        ]);
        
        $activity->eventid = $request->get('eventid');
        $activity->name = $request->get('name');
        $activity->location = $request->get('location');
        $activity->schedule = $request->get('schedule');
        $activity->save();

        return redirect('activities')->with('success','Activity has been updated.');
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
}
