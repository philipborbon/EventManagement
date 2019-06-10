<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use EventManagement\User;

class UserController extends Controller
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
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->validate(request(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'usertype' => Rule::in(['employee', 'investor', 'participants']),
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => Rule::in(['F', 'M']),
            'maritalstatus' => Rule::in(['single', 'married', 'divorced', 'separated', 'widowed'])
        ]);

        $user['password'] = bcrypt($user['password']);

        User::create($user);

        return back()->with('success', 'User has been added.');
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
        $user = User::find($id);
        return view('user.edit', compact('id', 'user'));
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
        $user = User::find($id);

        $this->validate(request(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $id,
            'password' => 'string|nullable',
            'password_confirmation' => 'string|nullable|required_with:password|same:password',
            'usertype' => Rule::in(['employee', 'investor', 'participants']),
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => Rule::in(['F', 'M']),
            'maritalstatus' => Rule::in(['single', 'married', 'divorced', 'separated', 'widowed'])
        ]);
        $user->firstname = $request->get('firstname');
        $user->lastname = $request->get('lastname');
        $user->email = $request->get('email');

        $password = $request->get('password');
        if ( $password != "" ){
            $user->password = bcrypt($request->get('password')); 
        }

        $user->usertype = $request->get('usertype');
        $user->address = $request->get('address');
        $user->age = $request->get('age');
        $user->sex = $request->get('sex');
        $user->maritalstatus = $request->get('maritalstatus');
        $user->save();


        return redirect('users')->with('success','User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('users')->with('success','User has been deleted.');
    }
}