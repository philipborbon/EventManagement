<?php

namespace EventManagement\Http\Controllers;

use Illuminate\Http\Request;
use EventManagement\Announcement;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::all();
        return view('announcement.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $announcement = $this->validate(request(), [
            'headline' => 'required|string',
            'description' => 'required|string',
            'active' => Rule::in([1, 0])
        ]);

        Announcement::create($announcement);

        return back()->with('success', 'Announcement has been added.');
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
        $announcement = Announcement::find($id);
        return view('announcement.edit', compact('id', 'announcement'));
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
            'headline' => 'required|string',
            'description' => 'required|string',
            'active' => Rule::in([1, 0])
        ]);

        $announcement = Announcement::find($id);
        $announcement->headline = $request->get('headline');
        $announcement->description = $request->get('description');
        $announcement->active = $request->get('active') == "1" ? true : false;

        $announcement->save();

        return redirect('announcements')->with('success', 'Announcement has been updated.');
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
