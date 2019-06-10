<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\DocumentType;
use Storage;
use Auth;
use EventManagement\UserIdentification;

class UserIdentificationController extends Controller
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
        $identifications = UserIdentification::all();
        return view('useridentification.index', compact('identifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = DocumentType::all();
        return view('useridentification.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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


    public function upload(Request $request)
    {
        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs (
            'files/'.$filename,
            $uploadedFile,
            $filename
        );

        $identification = $this->validate(request(), [
            'documenttypeid' => 'required|exists:document_types,id'
        ]);

        $identification['attachment'] = $filename;
        $identification['userid'] = Auth::user()->id;

        UserIdentification::create($identification);

        return response()->json($identification);
    }

    public function removeFile(Request $request){
        $filename = $request->get('name');
        Storage::disk('local')->delete('files/'.$filename);

        return response()->json([
            'deleted' => true,
            'filename' => $filename
        ]);
    }
}
