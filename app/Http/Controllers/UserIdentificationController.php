<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        $user = Auth::user();

        $userId = -1;
        if ($user->usertype != 'admin') {
            $userId = $user->id;
        }

        $identifications = $userId != -1 ? UserIdentification::where('userid', $userId)->get() :  UserIdentification::all();

        return view('useridentification.index', compact('identifications', 'user'));
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
        $identification = UserIdentification::find($id);
        $user = Auth::user();
        return view('useridentification.show', compact('identification', 'user'));
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
        $identification = UserIdentification::find($id);

        Storage::disk('local')->delete('public/'.$identification->attachment);

        $identification->delete();

        return redirect('useridentifications')->with('success', 'User identification has been deleted.');
    }


    public function upload(Request $request)
    {
        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs (
            'public',
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
        Storage::disk('local')->delete('public/'.$filename);

        return response()->json([
            'deleted' => true,
            'filename' => $filename
        ]);
    }

    public function verify(Request $request, $id)
    {
        $identification = UserIdentification::find($id);
        $identification->verified = $request->get('verified');

        $identification->save();

        return redirect('useridentifications')->with('success', 'User identification has been verified status has been updated.');
    }
}
