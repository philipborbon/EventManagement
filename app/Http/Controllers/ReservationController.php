<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\RentalSpace;
use EventManagement\Reservation;
use EventManagement\ProofOfPayment;
use EventManagement\Payment;
use EventManagement\DocumentType;
use Storage;
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

        $reservation = Reservation::create($reservation);

        $space = $reservation->rentalSpace;
        $space->status = 'reserved';
        $space->save();

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
        $types = DocumentType::all();
        return view('reservation.proofcreate', compact('types', 'id'));
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

        $payment = Payment::where('reservationid', $id)->first();

        if ( $payment ){
            $firstProof = $payment->proofs->first();

            if ($firstProof) {
                Storage::disk('local')->delete('public/'.$firstProof->attachment);
                $firstProof->documenttypeid = $proof['documenttypeid'];
                $firstProof->attachment = $filename;

                $firstProof->save();

                $proof = $firstProof;
            } else {
                $proof['attachment'] = $filename;
                $proof['paymentid'] = $payment->id;

                ProofOfPayment::create($proof);
            }
        } else {
            $user = Auth::user();
            $reservation = Reservation::find($id);

            $payment = Payment::create ([
                'userid' => $user->id,
                'rentalspaceid' => $reservation->rentalspaceid,
                'reservationid' => $reservation->id,
                'amount' => $reservation->rentalSpace->amount,
                'verified' => 0
            ]);

            $proof['attachment'] = $filename;
            $proof['paymentid'] = $payment->id;

            ProofOfPayment::create($proof);
        }

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
