<?php

namespace EventManagement\Http\Controllers;

use DateTime;

use Illuminate\Http\Request;
use EventManagement\MayorSchedule;
use Illuminate\Validation\Rule;

class MayorScheduleController extends Controller
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

        $builder = MayorSchedule::orderBy('status', 'ASC')
            ->orderBy('schedule', 'ASC');

        if ($keyword) {
            $builder->where(function($query) use ($keyword) {
                $query->orWhere('name', 'like', "%" . $keyword . "%");
                $query->orWhere('location', 'like', "%" . $keyword . "%");
            });
        }

        if ($start) {
            $builder->where('schedule', '>=', $start);
        }

        if ($end) {
            $builder->where('schedule', '<=', $end);
        }

        $schedules = $builder->get();

        return view('mayorschedule.index', compact('schedules', 'keyword', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mayorschedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = $this->validate(request(), [
            'name' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date_format:"Y-m-d"',
            'time' => 'required|date_format:"H:i"',
            'status' => Rule::in(['cancelled', 'active', 'done'])
        ]);

        $dateTime = DateTime::createFromFormat('Y-m-d H:i', $schedule['date'] . ' ' . $schedule['time']);

        $schedule['schedule'] = $dateTime->format('Y-m-d H:i:s');

        MayorSchedule::create($schedule);

        return back()->with('success', 'Mayor\'s schedule has been added.');
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
        $schedule = MayorSchedule::find($id);
        return view('mayorschedule.edit', compact('id', 'schedule'));
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
        $this->validate(request(), [
            'name' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date_format:"Y-m-d"',
            'time' => 'required|date_format:"H:i"',
            'status' => Rule::in(['cancelled', 'active', 'done'])
        ]);
        
        $dateTime = DateTime::createFromFormat('Y-m-d H:i', $request->get('date') . ' ' . $request->get('time'));

        $schedule = MayorSchedule::find($id);
        $schedule->name = $request->get('name');
        $schedule->location = $request->get('location');
        $schedule->schedule = $dateTime->format('Y-m-d H:i:s');
        $schedule->status = $request->get('status');
        $schedule->save();

        return redirect('mayorschedules')->with('success','Mayor\'s schedule has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = MayorSchedule::find($id);
        $schedule->delete();

        return redirect('mayorschedules')->with('success','Mayor\'s schedule has been deleted.');
    }
}
