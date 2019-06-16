<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\RentalSpace;
use EventManagement\Reservation;
use Auth;

class ReservationController extends Controller
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
        return view('reservation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $space = RentalSpace::find(request()->input('spaceid'));
        $user = Auth::user();

        return view('reservation.create', compact('space', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservation = $this->validate(request(), [
            'userid' => 'required|exists:users,id',
            'rentalspaceid' => 'required|exists:rental_spaces,id',
            'status' => 'in:onhold,awarded,cancelled,waved'
        ]);

        Reservation::create($reservation);

        return redirect('rentaspace/reservations')->with('success', 'Reservation has been added');
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
        //
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
        //
    }

    public function spaces(){
        $spaces = RentalSpace::with('coordinates')
            ->whereHas('event', function($query){
                $query->where('status', 'active');
            })
            ->has('coordinates', '>', '0')
            ->orderBy('name')->get();

        return view('reservation.space', compact('spaces'));
    }

    public function reservations(){
        $user = Auth::user();
        $reservations = Reservation::where('userid', $user->id)->get();

        return view('reservation.reservation', compact('reservations'));
    }

    public function createProof($id){

    }
}
