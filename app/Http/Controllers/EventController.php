<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use EventManagement\Event;

class EventController extends Controller
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
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $start = $request->input('start');
        $end = $request->input('end');

        $builder = Event::query();

        if ($keyword) {
            $builder->where('name', 'like', "%" . $keyword . "%");
        }

        if ($start) {
            $builder->where('startdate', '>=', $start);
        }

        if ($end) {
            $builder->where('enddate', '<=', $end);
        }

        $events = $builder->get();

        return view('event.index', compact('events', 'keyword', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.create');
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
            'name' => 'required|string',
            'description' => 'required|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
            'status' => Rule::in(['cancelled', 'active', 'done'])
        ]);

        Event::create($event);

        return back()->with('success', 'Event has been added.');
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
        $event = Event::find($id);
        return view('event.edit', compact('id', 'event'));
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
        $event = Event::find($id);

        $this->validate(request(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
            'status' => Rule::in(['cancelled', 'active', 'done'])
        ]);
        
        $event->name = $request->get('name');
        $event->description = $request->get('description');
        $event->startdate = $request->get('startdate');
        $event->enddate = $request->get('enddate');
        $event->status = $request->get('status');
        $event->save();

        return redirect('events')->with('success','Event has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return redirect('events')->with('success','Event has been deleted.');
    }
}
