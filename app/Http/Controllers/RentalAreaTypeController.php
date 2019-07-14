<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\RentalAreaType;
use EventManagement\RentalTypeArea;

class RentalAreaTypeController extends Controller
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
        $types = RentalAreaType::all();
        return view('rentalareatype.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rentalareatype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = $this->validate(request(), [
            'name' => 'required|string'
        ]);

        RentalAreaType::create($type);

        return back()->with('success', 'Area Type has been added.');
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
        $type = RentalAreaType::find($id);
        return view('rentalareatype.edit', compact('id', 'type'));
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
        $type = RentalAreaType::find($id);

        $this->validate(request(), [
            'name' => 'required|string'
        ]);
        $type->name = $request->get('name');
        $type->save();

        return redirect('rentalareatypes')->with('success','Area Type has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = RentalAreaType::find($id);
        $type->delete();
        return redirect('rentalareatypes')->with('success','Area Type has been deleted.');
    }

    public function typeMap($id){
        $type = RentalAreaType::find($id);

        $typeArea = RentalTypeArea::where('areatypeid', $id)->get();
        $otherTypes = RentalAreaType::with('coordinates')
                        ->where('id', '!=', $id)
                        ->has('coordinates', '>', '0')
                        ->get();

        $areas = [];

        foreach($typeArea as $area){
            $areas[] = [
                'lat' => floatval($area->latitude),
                'lng' => floatval($area->longitude)
            ];
        }

        return view('rentalareatype.map', compact('id', 'type', 'otherTypes', 'areas'));
    }

    public function updateMap(Request $request, $id){
        $this->validate(request(), [
            'vertices' => 'required|string'
        ]);

        RentalTypeArea::where('areatypeid', $id)->delete();

        $vertices = $request->get('vertices');
        $vertices = trim(trim($vertices, ')'), '(');
        $vertices = explode('),(', $vertices);

        $data = array();

        foreach($vertices as $vertix){
            $coordinate = explode(',', $vertix);

            $data[] = [
                'areatypeid' => $id,
                'latitude' => $coordinate[0],
                'longitude' => $coordinate[1]
            ];
        }

        RentalTypeArea::insert($data);

        return redirect('rentalareatypes')->with('success','Rental type map has been updated.');
    }
}
