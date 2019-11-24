<?php

namespace EventManagement\Http\Controllers;

use DateTime;

use Illuminate\Http\Request;
use EventManagement\Activity;
use EventManagement\Event;
use EventManagement\EventParticipant;
use Illuminate\Validation\Rule;
use EventManagement\User;

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

    public function participants($id, Request $request){
        $keyword = $request->input('keyword');

        $builder = EventParticipant::join('users', 'users.id', '=', 'userid');
        $builder->where('activityid', $id);
        $builder->orderBy('users.lastname', 'ASC');

        if ($keyword) {
            $builder->where(function($query) use ($keyword) {
                $query->orWhere('users.firstname', 'like', "%" . $keyword . "%");
                $query->orWhere('users.lastname', 'like', "%" . $keyword . "%");
            });
        }

        $activity = Activity::find($id);
        $participants = $builder->get();

        return view('activity.participant', compact('id', 'participants', 'activity', 'keyword'));
    }

    public function createParticipant($id){
        $activity = Activity::find($id);
        $users = User::where('usertype', 'participant')->get();
        return view('activity.create-participant', compact('id', 'activity', 'users'));
    }

    public function storeParticipant(Request $request, $id){
        $participant = $this->validate(request(), [
            'activityid' => 'required|exists:activities,id',
            'userid' => 'required|unique_with:event_participants,userid,activityid|exists:users,id',
            'accepted' => 'sometimes|required|in:1,0'
        ]);

        $participant = EventParticipant::create($participant);

        if ($participant->accepted) {
            return back()->with('success', 'Participant has been added.');
        } else {
            return back()->with('success', 'Registration has been added.');
        }
    }

    public function acceptParticipant($id, $participantId){
        $participant = EventParticipant::find($participantId);
        $participant->accepted = true;
        $participant->denied = false;

        $participant->save();

        return redirect('activities/' . $id . '/participants')->with('success','Participant has been accepted.');
    }

    public function denyParticipant($id, $participantId){
        $participant = EventParticipant::find($participantId);
        $participant->accepted = false;
        $participant->denied = true;

        $participant->save();

        return redirect('activities/' . $id . '/participants')->with('success','Participant has been denied.');
    }

    public function destroyParticipant($id, $participantId)
    {
        $participant = EventParticipant::find($participantId);
        $participant->delete();
        return redirect('activities/' . $id . '/participants')->with('success','Participant has been deleted.');
    }
}
