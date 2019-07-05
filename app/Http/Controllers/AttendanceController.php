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
                ->whereHas('user', function($query) {
                    $user = Auth::user();
                    $query->where('userid', $user->id);
                })
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
            'ishalfday' => 'in:1,0',
            'doublepay' => 'in:1,0',
            'overtime' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'status' => Rule::in(['onduty', 'onleave'])
        ]);

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
            'ishalfday' => 'in:1,0',
            'doublepay' => 'in:1,0',
            'overtime' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'status' => Rule::in(['onduty', 'onleave'])
        ]);

        $attendance = Attendance::find($id);
        $attendance->userid = $request->get('userid');
        $attendance->date = $request->get('date');
        $attendance->ishalfday = $request->get('ishalfday');
        $attendance->doublepay = $request->get('doublepay');
        $attendance->overtime = $request->get('overtime');
        $attendance->status = $request->get('status');

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
