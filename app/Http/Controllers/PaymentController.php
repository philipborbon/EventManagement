<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\Payment;
use EventManagement\User;
use EventManagement\RentalSpace;
use EventManagement\ProofOfPayment;
use EventManagement\DocumentType;
use Storage;
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

    public function proof($id)
    {
        $payment = Payment::find($id);
        $proofs = ProofOfPayment::where('paymentid', $id)->get();
        return view('payment.proof', compact('proofs', 'payment', 'id'));
    }

    public function createProof($id){
        $types = DocumentType::all();
        return view('payment.proofcreate', compact('types', 'id'));
    }

    public function showProof($id, $proofId){
        $proof = ProofOfPayment::find($proofId);
        return view('payment.proofshow', compact('proof', 'id'));
    }

    public function destroyProof($id, $proofId){
        $proof = ProofOfPayment::find($proofId);

        Storage::disk('local')->delete('public/'.$proof->attachment);

        $proof->delete();

        return redirect('payments/'.$id.'/proof')->with('success', 'Proof Of Payment has been deleted.');
    }

    public function uploadProof(Request $request, $id)
    {
        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs (
            'public',
            $uploadedFile,
            $filename
        );

        $proof = $this->validate(request(), [
            'documenttypeid' => 'required|exists:document_types,id'
        ]);

        $proof['attachment'] = $filename;
        $proof['paymentid'] = $id;

        ProofOfPayment::create($proof);

        return response()->json($proof);
    }

    public function removeFile(Request $request, $id){
        $filename = $request->get('name');
        Storage::disk('local')->delete('public/'.$filename);

        return response()->json([
            'deleted' => true,
            'filename' => $filename
        ]);
    }
}
