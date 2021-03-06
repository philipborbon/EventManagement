<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\Attendance;
use EventManagement\User;
use Illuminate\Validation\Rule;
use Auth;

class AttendanceController extends Controller
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
        $user = Auth::user();
        $attendances = NULL;

        if ( Auth::user()->usertype == 'admin' ) {
            $attendances = Attendance::join('users', 'users.id', '=', 'userid')
                ->orderBy('date', 'DESC')
                ->orderBy('users.lastname', 'ASC')
                ->orderBy('users.firstname', 'ASC')
                ->select('attendances.*')
                ->get();
        } else {
            $attendances = Attendance::with('user')
                ->orderBy('date', 'DESC')
                ->where('userid', $user->id)
                ->get();
        }

        return view('attendance.index', compact('attendances', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = User::where('usertype', 'employee')
            ->orderBy('lastname', 'ASC')
            ->get();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendance = $this->validate(request(), [
            'userid' => 'required|exists:users,id',
            'date' => 'required|date_format:"Y-m-d|unique_with:attendances,date,userid',
            'doublepay' => 'in:1,0',
            'status' => Rule::in(['onduty', 'onleave']),
            'amin' => 'nullable|date_format:"H:i"',
            'amout' => 'nullable|after:amin|date_format:"H:i"',
            'pmin' => 'nullable|after:amout|date_format:"H:i"',
            'pmout' => 'nullable|after:pmin|date_format:"H:i"'
        ]);

        if ($attendance['status'] == 'onleave') {
            $attendance['amin'] = NULL;
            $attendance['amout'] = NULL;
            $attendance['pmin'] = NULL;
            $attendance['pmout'] = NULL;
        }

        Attendance::create($attendance);

        return back()->with('success', 'Attendance has been added.');
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
        $attendance = Attendance::find($id);
        return view('attendance.edit', compact('attendance', 'id'));
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
            'userid' => 'required|exists:users,id',
            'date' => 'required|date_format:"Y-m-d|unique_with:attendances,date,userid,' . $id,
            'doublepay' => 'in:1,0',
            'status' => Rule::in(['onduty', 'onleave']),
            'amin' => 'nullable|date_format:"H:i"',
            'amout' => 'nullable|after:amin|date_format:"H:i"',
            'pmin' => 'nullable|after:amout|date_format:"H:i"',
            'pmout' => 'nullable|after:pmin|date_format:"H:i"'
        ]);

        $attendance = Attendance::find($id);
        $attendance->userid = $request->get('userid');
        $attendance->date = $request->get('date');
        $attendance->doublepay = $request->get('doublepay');
        $attendance->status = $request->get('status');

        if ($attendance->status == 'onleave') {
            $attendance->amin = NULL;
            $attendance->amout = NULL;
            $attendance->pmin = NULL;
            $attendance->pmout = NULL;
        } else {
            $attendance->amin = $request->get('amin');
            $attendance->amout = $request->get('amout');
            $attendance->pmin = $request->get('pmin');
            $attendance->pmout = $request->get('pmout');
        }

        $attendance->save();

        return redirect('attendances')->with('success', 'Attendance has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();

        return redirect('attendances')->with('success', 'Attendance has been deleted');
    }
}
