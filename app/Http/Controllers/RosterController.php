<?php

namespace App\Http\Controllers;

use App\Roster;
use App\Realm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rosters = Roster::all();

        return view('rosters.index', compact('rosters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $realms = Realm::all();

        return view('rosters.create', compact('realms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name'    => 'required',
            'realm'   => 'required',
            'faction' => 'required'
        ]);

        $newRoster = new Roster();

        $newRoster->name = $request->name;
        $newRoster->realm = $request->realm;
        $newRoster->faction = $request->faction;
        $newRoster->owner_id = auth()->id();

        $newRoster->save();

        return redirect("rosters/$newRoster->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $roster
     * @return \Illuminate\Http\Response
     */
    public function show(Roster $roster)
    {
        return view('rosters.view', compact('roster'));
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
}
