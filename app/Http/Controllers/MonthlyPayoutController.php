<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\MonthlyPayout;
use EventManagement\Attendance;
use EventManagement\SalaryGrade;
use EventManagement\EmployeeActiveDeduction;
use EventManagement\PayoutDeduction;
use DB;
use Auth;

class MonthlyPayoutController extends Controller
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

        $payouts = NULL;

        if ($user->usertype == 'admin') {
            $payouts = MonthlyPayout::join('users', 'users.id', '=', 'userid')
                ->orderBy('dateavailable', 'DESC')
                ->orderBy('users.lastname', 'ASC')
                ->select('monthly_payouts.*')
                ->get();                                
        } else {
            $payouts = MonthlyPayout::orderBy('dateavailable', 'DESC')
                        ->where('userid', $user->id)
                        ->get();
        }

        return view('payout.index', compact('payouts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payout.create');
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
        $payout = MonthlyPayout::with('deductions')
            ->where('id', $id)->first();

        return view('payout.edit', compact('payout', 'id'));
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
            'datecollected' => 'required|date_format:"Y-m-d"'
        ]);

        $payout = MonthlyPayout::find($id);
        $payout->datecollected = $request->get('datecollected');
        $payout->save();

        return redirect('payslips')->with('success', 'Monthly Payslip for ' . $payout->user->getFullname() . ' has been collected.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payout = MonthlyPayout::find($id);
        $payout->delete();

        return redirect('payslips')->with('success', 'Monthly Payslip for ' . $payout->user->getFullname() . ' has been deleted.');
    }

    public function generate(Request $request) {
        $this->validate(request(), [
            'month' => 'required|date_format:"m"',
            'year' => 'required|date_format:"Y"',
            'dateavailable' => 'required|date_format:"Y-m-d"'
        ]);

        $month = $request->get('month');
        $year = $request->get('year');
        $dateavailable = $request->get('dateavailable');

        $attendances = DB::select("
            SELECT userid, 
            
            SUM(
                (IF (
                    status = 'onleave', 8, 
                    IF (
                        (
                            (IF(amout > 0, IF(amin > 0, TIME_TO_SEC(TIMEDIFF(amout, amin)), 0), 0)/3600)
                            + 
                            (IF(pmout > 0, IF(pmin > 0, TIME_TO_SEC(TIMEDIFF(pmout, pmin)), 0), 0)/3600)
                        ) <= 8,
                        (
                            (IF(amout > 0, IF(amin > 0, TIME_TO_SEC(TIMEDIFF(amout, amin)), 0), 0)/3600)
                            + 
                            (IF(pmout > 0, IF(pmin > 0, TIME_TO_SEC(TIMEDIFF(pmout, pmin)), 0), 0)/3600)
                        ), 
                        8
                    )
                ) + (
                    (
                        IF (
                            (
                                (IF(amout > 0, IF(amin > 0, TIME_TO_SEC(TIMEDIFF(amout, amin)), 0), 0)/3600)
                                + 
                                (IF(pmout > 0, IF(pmin > 0, TIME_TO_SEC(TIMEDIFF(pmout, pmin)), 0), 0)/3600)
                            ) > 8,
                            (
                                (IF(amout > 0, IF(amin > 0, TIME_TO_SEC(TIMEDIFF(amout, amin)), 0), 0)/3600)
                                + 
                                (IF(pmout > 0, IF(pmin > 0, TIME_TO_SEC(TIMEDIFF(pmout, pmin)), 0), 0)/3600)
                            ) - 8, 
                            0
                        )
                    ) * 2
                )) * IF(doublepay = 1, 2, 1)
            ) AS totalhours

            FROM `attendances`
            WHERE DATE_FORMAT(date, '%m %Y') = '$month $year'
            GROUP BY userid, DATE_FORMAT(date, '%m %Y')
        ");

        foreach($attendances as $attendance){
            $salaryGrade = SalaryGrade::where('userid', $attendance->userid)->first();
            $hourlySalary = (double) ($salaryGrade->dailypay / 8);
            $totalhours = (double) $attendance->totalhours;

            $salary = $hourlySalary * $totalhours;

            $deductions = EmployeeActiveDeduction::where('userid', $attendance->userid)->get();

            $totalDeduction = 0.0;
            $payoutDeductions = array();
            foreach($deductions as $deduction) {
                $totalDeduction += (double) $deduction->amount;
                $payoutDeductions[] = array (
                    'payoutid' => 0,
                    'typeid' => $deduction->typeid,
                    'amount' => $deduction->amount
                );
            }

            $payout = MonthlyPayout::create([
                'userid' => $attendance->userid,
                'payout' => $salary,
                'actualpayout' => $salary - $totalDeduction,
                'dateavailable' => $dateavailable
            ]);

            foreach($payoutDeductions as $deduction){
                $deduction['payoutid'] = $payout->id;

                PayoutDeduction::create($deduction);
            }
        }

        $month = config('enums.months')[$month];

        return redirect('payslips')->with('success', 'Payslip for month of ' . "$month, $year" . ' has been created.');
    }
}
