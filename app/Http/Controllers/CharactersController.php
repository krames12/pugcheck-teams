<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterGear;
use App\Realm;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class CharactersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Import single character page
     * @return \Illuminate\Http\Response
     */
    public function import() {
        $realms = \App\Realm::all();

        return view('characters.import', compact('realms'));
    }

    /**
     * Import character from Blizzard API
     */
    public function importCharacter()
    {
        $this->validate(request(), [
            'name'  => 'required',
            'realm' => 'required'
        ]);

        $realm = Realm::find(request('realm'));
        $requestUrl = "https://us.api.battle.net/wow/character/".$realm->slug."/".request('name')."?fields=items&locale=en_US&apikey=".env('BLIZZ_KEY');

        $client = new Client();
        try {
            $res = $client->request('GET', $requestUrl);
            $this->handleCharacterImport(json_decode($res->getBody()), request('realm'));

            // Redirect to import page.
            return redirect('characters/import');
        } catch (RequestException $e) {
            if($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }

    /**
     * Creates character and character item records
    */
    public function handleCharacterImport($character, $realmId) {
        $characterExists = Character::where([['name', '=', $character->name], ['realm', '=', $realmId]])->first();
        if($characterExists === null) {
            // Create new character
            $newCharacter = new Character();

            $newCharacter->name = htmlspecialchars($character->name);
            $newCharacter->realm = request('realm');
            $newCharacter->class = $character->class;
            $newCharacter->race = $character->race;
            $newCharacter->faction = $character->faction;
            $newCharacter->item_level = $character->items->averageItemLevel;

            // Save Character
            $newCharacter->save();

            foreach($character->items as $key => $item) {
                if($key == "averageItemLevelEquipped" || $key == "averageItemLevel") {
                    continue;
                }
                $newItem = new CharacterGear();

                $newItem->blizz_id = $item->id;
                $newItem->character_id = $newCharacter->id;
                $newItem->item_slot = $key;
                $newItem->name = $item->name;
                $newItem->item_level = $item->itemLevel;

                if($key == "neck"){
                    $characterInfo = Character::find($newCharacter->id);
                    $characterInfo->azerite_level = $item->azeriteItem->azeriteLevel;
                    $characterInfo->save();
                }

                $newItem->save();
            }
        } else {
            $existingCharacter = Character::find($characterExists->id);

            foreach($character->items as $key => $item) {
                if($key == "averageItemLevelEquipped" || $key == "averageItemLevel") {
                    continue;
                }
                $existingItem = CharacterGear::where([
                    ['item_slot', '=', $key],
                    ['character_id', '=', $existingCharacter->id]
                ])->first();

                $existingItem->blizz_id = $item->id;
                $existingItem->item_slot = $key;
                $existingItem->name = $item->name;
                $existingItem->item_level = $item->itemLevel;

                if($key == "neck"){
                    $existingCharacter->azerite_level = $item->azeriteItem->azeriteLevel;
                }

                $existingItem->save();
            }

            $existingCharacter->item_level = $character->items->averageItemLevel;
            $existingCharacter->save();
        }
    }
}
