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
use phpDocumentor\Reflection\Types\Array_;
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
            'name'          => 'required',
            'guild_name'    => 'required',
            'realm'         => 'required',
            'faction'       => 'required'
        ]);

        $newRoster = new Roster();

        $newRoster->name = $request->name;
        $newRoster->guild_name = $request->guild_name;
        $newRoster->realm_id = $request->realm;
        $newRoster->faction = $request->faction;
        $newRoster->user_id = auth()->id();

        $newRoster->save();

        return redirect("rosters/$newRoster->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  Roster $roster
     * @return \Illuminate\Http\Response
     */
    public function show(Roster $roster)
    {
        $tanks = $roster->characters()->where('main_spec', '=', 'tank')->get();
        $healers = $roster->characters()->where('main_spec', '=', 'healer')->get();
        $melee = $roster->characters()->where('main_spec', '=', 'mdps')->get();
        $ranged = $roster->characters()->where('main_spec', '=', 'rdps')->get();

//        dd($melee);

        return view('rosters.view', compact(['roster', 'tanks', 'healers', 'melee', 'ranged']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Roster $roster)
    {
        $realms = Realm::all();
        return view('rosters.edit', compact(['roster', 'realms']));
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
        $roster = Roster::find($id);

        $roster->name = $request->name;
        $roster->guild_name = $request->guild_name;
        $roster->realm_id = $request->realm;
        $roster->faction = $request->faction;

        $roster->save();

        return redirect("/rosters/$id")->with('success', 'Roster has been updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $rosterId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, Roster $roster)
    {
        foreach($request->characters as $character) {
            if(isset($character['remove'])) {
                $roster->characters()->detach($character['id']);
            } else {
                $roster->characters()->updateExistingPivot($character['id'], [
                    'main_spec' => $character['main_spec']
                ]);
            }
        }
        return redirect("/rosters/$roster->id")->with('success', "Roles have been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roster $roster)
    {
        $roster->characters()->detach($roster->id);
        $roster->delete();

        redirect('/rosters')->with('success', 'Team has been removed');
    }

    /**
     * Import members from a guild to the roster.
     *
     * @param int $rosterId
     * @return \Illuminate\Http\Response
    */
    public function import(Roster $roster)
    {
        $realmSlug = $roster->realm->slug;
        $requestUrl = "https://us.api.battle.net/wow/guild/$realmSlug/$roster->guild_name?fields=members&locale=en_US&apikey=".env('BLIZZ_KEY');

        $client = new Client();
        try {
            $res = $client->request('GET', $requestUrl);
            $response = json_decode($res->getBody());

            $members = collect($response->members)
                            ->sortBy('rank')
                            ->filter(function($value, $key) {
                                return $value->character->level == 120;
                            });

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
