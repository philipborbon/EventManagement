<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\DocumentType;

class DocumentTypeController extends Controller
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
    	$documenttypes = DocumentType::all();
    	return view('documenttype.index', compact('documenttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('documenttype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $document = $this->validate(request(), [
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        DocumentType::create($document);

        return back()->with('success', 'Document type has been added.');
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
    	$document = DocumentType::find($id);
    	return view('documenttype.edit', compact('id', 'document'));
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
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

		$document = DocumentType::find($id);
		$document->name = $request->get('name');
		$document->description = $request->get('description');

		return redirect('documenttypes')->with('success','Document Type has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$document = DocumentType::find($id);
		$document->delete();
		return redirect('documenttypes')->with('success','Document Type has been updated.');
    }
}
