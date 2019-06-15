<?php

namespace EventManagement\Http\Controllers;

use DateTime;

use Illuminate\Http\Request;
use EventManagement\Activity;
use EventManagement\Event;
use EventManagement\EventParticipant;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        $activity = $this->validate(request(), [
            'eventid' => 'required|exists:events,id',
            'name' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date_format:"Y-m-d"',
            'time' => 'required|date_format:"H:i"'
        ]);

        $dateTime = DateTime::createFromFormat('Y-m-d H:i', $activity['date'] . ' ' . $activity['time']);

        $activity['schedule'] = $dateTime->format('Y-m-d H:i:s');

        Activity::create($activity);

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
            'date' => 'required|date_format:"Y-m-d"',
            'time' => 'required|date_format:"H:i"'
        ]);
        
        $dateTime = DateTime::createFromFormat('Y-m-d H:i', $request->get('date') . ' ' . $request->get('time'));

        $activity->eventid = $request->get('eventid');
        $activity->name = $request->get('name');
        $activity->location = $request->get('location');
        $activity->schedule = $dateTime->format('Y-m-d H:i:s');
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
        $activity = Activity::find($id);
        $activity->delete();
        return redirect('activities')->with('success','Activity has been deleted.');
    }

    public function participants($id){
        $participants = EventParticipant::where('activityid', $id)->get();
        $activity = Activity::find($id);
        return view('activity.participant', compact('id', 'participants', 'activity'));
    }

    public function createParticipant($id){
        $activity = Activity::find($id);
        return view('activity.create-participant', compact('id', 'activity'));
    }

    public function storeParticipant(Request $request, $id){
        $participant = $this->validate(request(), [
            'activityid' => 'required|exists:activities,id',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => Rule::in(['F', 'M'])
        ]);

        EventParticipant::create($participant);

        return back()->with('success', 'Participant has been added.');
    }

    public function editParticipant($id, $participantId){
        $activity = Activity::find($id);
        $participant = EventParticipant::find($participantId);
        return view('activity.edit-participant', compact('id', 'participantId', 'activity', 'participant'));
    }

    public function updateParticipant(Request $request, $id, $participantId){
        $this->validate(request(), [
            'activityid' => 'required|exists:activities,id',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => Rule::in(['F', 'M']),
        ]);

        $participant = EventParticipant::find($participantId);
        $participant->firstname = $request->get('firstname');
        $participant->lastname = $request->get('lastname');
        $participant->address = $request->get('address');
        $participant->age = $request->get('age');
        $participant->sex = $request->get('sex');

        $participant->save();

        return redirect('activities/' . $id . '/participants')->with('success','Participant has been updated.');
    }

    public function destroyParticipant($id, $participantId)
    {
        $participant = EventParticipant::find($participantId);
        $participant->delete();
        return redirect('activities/' . $id . '/participants')->with('success','Participant has been deleted.');
    }
}
