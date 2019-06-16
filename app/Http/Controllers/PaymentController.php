<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\Payment;
use EventManagement\User;
use EventManagement\RentalSpace;
use DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $investors = User::where('usertype', 'investor')
            ->orderBy('lastname', 'ASC')
            ->get();

        $spaces = RentalSpace::whereHas('event', function($query){
                $query->where('status', 'active');
            })
            ->where('status', 'available')
            ->orderBy('name')->get();

        return view('payment.create', compact('investors', 'spaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = $this->validate(request(), [
            'userid' => 'required|exists:users,id',
            'rentalspaceid' => 'required|exists:rental_spaces,id',
            'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'verified' => 'in:1,0'
        ]);

        $payment = Payment::create($payment);

        if ( $payment->verified ) {
            $rentalSpace = $payment->rentalSpace;
            $rentalSpace->status = 'rented';

            $rentalSpace->save();

            DB::table('reservations')
                ->where('rentalspaceid', '=', $rentalSpace->id)
                ->where('status', '<>', 'waved')
                ->update(array('status' => 'cancelled'));
        }

        return back()->with('success', 'Payment has been added.');
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
        $payment = Payment::find($id);
        return view('payment.edit', compact('payment', 'id'));
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
            'rentalspaceid' => 'required|exists:rental_spaces,id',
            'reservationid' => 'nullable|exists:reservations,id',
            'amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'verified' => 'in:1,0'
        ]);

        $payment = Payment::find($id);
        $payment->verified = $request->get('verified');
        $payment->save();

        if ( $payment->verified ) {
            $rentalSpace = $payment->rentalSpace;
            $rentalSpace->status = 'rented';

            $rentalSpace->save();

            $reservation = $payment->reservation;
            if ( $reservation ) {
                $reservation->status = 'awarded';
                $reservation->save();

                DB::table('reservations')
                    ->where('rentalspaceid', '=', $rentalSpace->id)
                    ->where('id', '<>', $reservation->id)
                    ->where('status', '<>', 'waved')
                    ->update(array('status' => 'cancelled'));
            } else {
                DB::table('reservations')
                    ->where('rentalspaceid', '=', $rentalSpace->id)
                    ->where('status', '<>', 'waved')
                    ->update(array('status' => 'cancelled'));
            }
        } else {
            $rentalSpace = $payment->rentalSpace;
            $rentalSpace->status = 'available';

            $rentalSpace->save();

            $reservation = $payment->reservation;
            if ( $reservation ) {
                $reservation->status = 'cancelled';
                $reservation->save();
            }
        }

        return redirect('payments')->with('success', 'Payment has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ( $payment->verified ) {
            $rentalSpace = $payment->rentalSpace;
            $rentalSpace->status = 'available';

            $rentalSpace->save();

            $reservation = $payment->reservation;
            if ( $reservation ) {
                $reservation->status = 'cancelled';
                $reservation->save();
            }
        }

        $payment->delete();

        return redirect('payments')->with('success', 'Payment has been deleted.');
    }
}
