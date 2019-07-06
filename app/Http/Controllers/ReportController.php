<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
	public function financial(){
		$query = "
			SELECT p.id, DATE_FORMAT(p.created_at, '%M %d, %Y') AS date, u.lastname, u.firstname, s.name AS spacename, s.area, s.amount
			FROM payments p
			INNER JOIN users u ON p.userid = u.id
			INNER JOIN rental_spaces s ON p.rentalspaceid = s.id
            WHERE p.verified = true
            ORDER BY p.created_at, u.lastname, u.firstname
		";

		$reports = DB::select($query);
		$title = "Financial Report";

		return view('report.financial', compact('reports', 'title'));
	}
}
