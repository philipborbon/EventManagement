<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use EventManagement\User;
use Auth;

class AccountController extends Controller
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
        return view('account.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = Auth::user();
        $id = $user->id;

        return view('account.edit', compact('user', 'id'));
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
        $user = Auth::user();

        $this->validate(request(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'string|nullable',
            'password_confirmation' => 'string|nullable|required_with:password|same:password',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => Rule::in(['F', 'M']),
            'maritalstatus' => Rule::in(['single', 'married', 'divorced', 'separated', 'widowed'])
        ]);
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');

        $password = $request->get('password');
        if ( $password != "" ){
            $user->password = bcrypt($request->get('password')); 
        }

        $user->address = $request->get('address');
        $user->age = $request->get('age');
        $user->sex = $request->get('sex');
        $user->maritalstatus = $request->get('maritalstatus');
        $user->save();


        return redirect('account')->with('success','Account has been updated.');
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
}
