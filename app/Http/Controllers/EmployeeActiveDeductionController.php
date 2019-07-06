<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\EmployeeActiveDeduction;
use EventManagement\User;
use EventManagement\DeductionType;
use Auth;

class EmployeeActiveDeductionController extends Controller
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

        $deductions = NULL;

        if ( $user->usertype == 'admin' ) {
            $deductions = EmployeeActiveDeduction::join('users', 'users.id', '=', 'userid')
                ->orderBy('users.lastname', 'ASC')
                ->orderBy('users.firstname', 'ASC')
                ->select('employee_active_deductions.*')
                ->get();
        } else {
            $deductions = EmployeeActiveDeduction::with('user')
                ->where('userid', $user->id)
                ->get();
        }

        return view('activededuction.index', compact('deductions', 'user'));
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

        $types = DeductionType::orderBy('name', 'ASC')->get();

        return view('activededuction.create', compact('employees', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activededuction = $this->validate(request(), [
            'userid' => 'required|exists:users,id',
            'typeid' => 'required|exists:deduction_types,id|unique_with:employee_active_deductions,typeid,userid',
            'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        EmployeeActiveDeduction::create($activededuction);

        return back()->with('success', 'Employee Deduction has been added.');
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
        $deduction = EmployeeActiveDeduction::find($id);
        return view('activededuction.edit', compact('deduction', 'id'));
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
            'typeid' => 'required|exists:deduction_types,id|unique_with:employee_active_deductions,typeid,userid,' . $id,
            'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        $activededuction = EmployeeActiveDeduction::find($id);
        $activededuction->userid = $request->get('userid');
        $activededuction->typeid = $request->get('typeid');
        $activededuction->amount = $request->get('amount');

        $activededuction->save();

        return redirect('activedeductions')->with('success', 'Employee Deduction has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deduction = EmployeeActiveDeduction::find($id);
        $deduction->delete();

        return redirect('activedeductions')->with('success', 'Employee Deduction has been deleted.');
    }
}
