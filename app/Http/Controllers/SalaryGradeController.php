<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\SalaryGrade;
use EventManagement\User;

class SalaryGradeController extends Controller
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
        $users = SalaryGrade::with('user')->get();
        return view('salarygrade.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('usertype', 'employee')->get();
        return view('salarygrade.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $this->validate(request(), [
            'userid' => 'required|exists:users,id',
            'dailypay' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $grade = SalaryGrade::where('userid', $input['userid'])->first();

        if ($grade) {
            $grade->dailypay = $input['dailypay'];
            $grade->save();

            return redirect('salarygrades')->with('success', 'Salary has been updated.');
        } else {
            SalaryGrade::create($input);
            return redirect('salarygrades')->with('success', 'Salary has been assigned.');
        }
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
        $users = User::where('usertype', 'employee')->get();
        $grade = SalaryGrade::find($id);

        return view('salarygrade.create', compact('users', 'grade'));
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
        $grade = SalaryGrade::find($id);
        $grade->delete();
        return redirect('salarygrades')->with('success','Salary has been removed.');
    }
}
