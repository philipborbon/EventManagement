<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\DeductionType;

class DeductionTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $types = DeductionType::all();
        return view('deductiontype.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deductiontype.create');
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
          'name' => 'required|string',
          'description' => 'nullable|string'
        ]);

        DeductionType::create($type);

        return back()->with('success', 'Deduction type has been added');;
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
        $type = DeductionType::find($id);
        return view('deductiontype.edit', compact('type','id'));
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
        $type = DeductionType::find($id);

        $this->validate(request(), [
          'name' => 'required|string',
          'description' => 'nullable|string'
        ]);
        $type->name = $request->get('name');
        $type->description = $request->get('description');
        $type->save();


        return redirect('deductiontype')->with('success','Type has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = DeductionType::find($id);
        $type->delete();
        return redirect('deductiontype')->with('success','Type has been  deleted');
    }
}
