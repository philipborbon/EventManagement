<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\RentalAreaType;

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
}
