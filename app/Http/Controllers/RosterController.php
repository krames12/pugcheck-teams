<?php

namespace App\Http\Controllers;

use App\Roster;
use App\Realm;
use App\RosterCharacter;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Controllers\CharactersController;
use App\Http\Controllers\Lookups;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Psy\Util\Json;

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
        $newRoster->realm_id = $request->realm;
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
     * Update the specified resource in storage.
     *
     * @param $rosterId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, $rosterId)
    {
        foreach($request->characters as $character) {
            $roster = Roster::find($rosterId);
            if(isset($character['remove'])) {
                $roster->characters()->detach($character['id']);
            } else {
                $roster->characters()->updateExistingPivot($character['id'], [
                    'main_spec' => $character['main_spec'],
                    'off_spec' => $character['off_spec']
                ]);
            }
        }

        return redirect("/rosters/$rosterId");
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

    /**
     * Import members from a guild to the roster.
     *
     * @param int $rosterId
     * @return \Illuminate\Http\Response
    */
    public function import($rosterId)
    {
        $roster = Roster::find($rosterId);
        $realmSlug = $roster->realm->slug;
        $requestUrl = "https://us.api.battle.net/wow/guild/$realmSlug/$roster->name?fields=members&locale=en_US&apikey=".env('BLIZZ_KEY');

        $client = new Client();
        try {
            $res = $client->request('GET', $requestUrl);
            $response = json_decode($res->getBody());

            $members = collect($response->members)->sortBy('rank');
            // Redirect to import page.
            return view('rosters.import', compact('members', 'roster'));
        } catch (RequestException $e) {
            if($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }

    public function importGuild(Request $request, Roster $roster)
    {
        $existingCharacters = $roster->characters->whereIn('name', $request->characters);

        foreach($request->characters as $character) {
            if(!$existingCharacters->contains('name', $character)) {
                $character = Lookups::apiCharacter($character, $roster->realm->slug);

                $rosterCharacter = CharactersController::handleCharacterImport($character, $roster->realm->id);
                $roster->characters()->attach($rosterCharacter, ['main_spec' => 'unassigned', 'off_spec' => 'unassigned']);
            }
        }

        return redirect()->route('rosterShow', ['id' => $roster->id])
                         ->with('success', count($request->characters)." guild member have been imported");
    }
}
