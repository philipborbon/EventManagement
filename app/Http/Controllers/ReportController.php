<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function financial(Request $request)
    {
        $keyword = $request->input('keyword');
        $start = $request->input('start');
        $end = $request->input('end');

        $builder = DB::table('payments AS p')
            ->join('users AS u', 'p.userid', '=', 'u.id')
            ->join('rental_spaces AS s', 'p.rentalspaceid', '=', 's.id')
            ->where('p.verified', true)
            ->orderBy('p.created_at', 'u.lastname', 'u.firstname')
            ->select (
                'p.id', 
                DB::raw("DATE_FORMAT(p.created_at, '%M %d, %Y') AS date"), 
                'u.lastname', 
                'u.firstname', 
                's.name AS spacename', 
                's.area', 
                's.amount'
            );

        if ($keyword) {
            $builder->where(function($query) use ($keyword) {
                $query->orWhere('u.lastname', 'like', "%" . $keyword . "%");
                $query->orWhere('u.firstname', 'like', "%" . $keyword . "%");
                $query->orWhere('s.name', 'like', "%" . $keyword . "%");
            });
        }

        if ($start) {
            $builder->where('p.created_at', '>=', $start);
        }

        if ($end) {
            $builder->where('p.created_at', '<=', $end);
        }

        $reports = $builder->get();

		$title = 'Financial Report';

		return view('report.financial', compact('reports', 'title', 'keyword', 'start', 'end'));
	}
}
