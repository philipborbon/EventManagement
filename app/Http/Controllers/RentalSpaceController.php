<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use EventManagement\RentalSpace;
use EventManagement\Event;
use EventManagement\RentalAreaType;
use EventManagement\RentalSpaceArea;

class RentalSpaceController extends Controller
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
        $spaces = RentalSpace::with('event', 'type')->get();
        return view('rentalspace.index', compact('spaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::where('status', 'active')->get();
        $types = RentalAreaType::all();
        return view('rentalspace.create', compact('events', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $space = $this->validate(request(), [
            'eventid' => 'required|exists:events,id',
            'typeid' => 'required|exists:rental_area_types,id',
            'name' => 'required|string',
            'location' => 'required|string',
            'area' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'status' => Rule::in(['available', 'reserved', 'rented'])
        ]);

        RentalSpace::create($space);

        return back()->with('success', 'Rental space has been added.');
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
        $space = RentalSpace::find($id);
        $events = Event::where('status', 'active')->get();
        $types = RentalAreaType::all();
        return view('rentalspace.edit', compact('id', 'space', 'events', 'types'));
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
        $space = RentalSpace::find($id);

        $this->validate(request(), [
            'eventid' => 'required|exists:events,id',
            'typeid' => 'required|exists:rental_area_types,id',
            'name' => 'required|string',
            'location' => 'required|string',
            'area' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'status' => Rule::in(['available', 'reserved', 'rented'])
        ]);

        $space->eventid = $request->get('eventid');
        $space->typeid = $request->get('typeid');
        $space->name = $request->get('name');
        $space->location = $request->get('location');
        $space->area = $request->get('area');
        $space->amount = $request->get('amount');
        $space->status = $request->get('status');

        $space->save();

        return redirect('rentalspaces')->with('success','Rental space has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $space = RentalSpace::find($id);
        $space->delete();
        return redirect('rentalspaces')->with('success','Rental space has been deleted.');
    }

    public function spaceMap($id){
        $space = RentalSpace::find($id);

        $spaceAreas = RentalSpaceArea::where('rentalspaceid', $id)->get();
        $otherSpaces = RentalSpace::with('coordinates')
                        ->where('id', '!=', $id)
                        ->has('coordinates', '>', '0')
                        ->get();

        $areas = [];

        foreach($spaceAreas as $area){
            $areas[] = [
                'lat' => floatval($area->latitude),
                'lng' => floatval($area->longitude)
            ];
        }

        return view('rentalspace.map', compact('id', 'space', 'otherSpaces', 'areas'));
    }

    public function updateMap(Request $request, $id){
        $this->validate(request(), [
            'vertices' => 'required|string',
            'area' => 'required|regex:/^\d+(\.\d{1,2})?$/'                              
        ]);

        $space = RentalSpace::find($id);
        $space->area = $request->get('area');

        $space->save();

        RentalSpaceArea::where('rentalspaceid', $id)->delete();

        $vertices = $request->get('vertices');
        $vertices = trim(trim($vertices, ')'), '(');
        $vertices = explode('),(', $vertices);

        $data = array();

        foreach($vertices as $vertix){
            $coordinate = explode(',', $vertix);

            $data[] = [
                'rentalspaceid' => $id,
                'latitude' => $coordinate[0],
                'longitude' => $coordinate[1]
            ];
        }

        RentalSpaceArea::insert($data);

        return redirect('rentalspaces')->with('success','Rental space map has been updated.');
    }
}
