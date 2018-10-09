<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterGear;
use App\ItemProperties;
use App\Realm;
use App\Roster;

use App\Http\Controllers\Lookups;

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
    public function import(Roster $roster) {
        $realms = \App\Realm::where('region', 'us')->get();;

        return view('characters.import', compact(['realms', 'roster']));
    }

    /**
     * Import character from Blizzard API
     */
    public function importCharacter(Roster $roster)
    {
        $this->validate(request(), [
            'name'  => 'required',
            'realm' => 'required'
        ]);

        $realm = Realm::find(request('realm'));
        $character = Lookups::apiCharacter(request('name'), $realm->slug);
        if(isset($character->name)) {
            $importedCharacter = $this::handleCharacterImport($character, request('realm'));
            $roster->characters()->attach($importedCharacter, ['main_spec' => 'unassigned', 'off_spec' => 'unassigned']);

            return redirect("/rosters/$roster->id")->with('success', 'Character has been imported');
        } else {
            return back()->with('error', 'Character does not exist');
        }
    }

    /**
     * Creates character and character item records
    */
    public static function handleCharacterImport($character, $realmId) {
        $characterExists = Character::where([['name', '=', $character->name], ['realm', '=', $realmId]])->first();
        if($characterExists === null) {
            $newCharacter = self::createCharacter($character, $realmId);
            return $newCharacter;
        } else {
            $existingCharacter = Character::find($characterExists->id);
            $updatedCharacter = self::updateCharacter($character, $existingCharacter);
            return $updatedCharacter;
        }
    }

    private static function createCharacter($character, $realmId)
    {
        $newCharacter = new Character();

        $newCharacter->name = htmlspecialchars($character->name);
        $newCharacter->realm = $realmId;
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
            $newItem->bonus_ids = json_encode($item->bonusLists);

            if($key == "neck"){
                $characterInfo = Character::find($newCharacter->id);
                $characterInfo->azerite_level = $item->azeriteItem->azeriteLevel;
                $characterInfo->save();
            }

            $newItem->save();

            self::updateItemProperties($key, $item, $newItem->id);
        }

        return $newCharacter->id;
    }

    public static function updateCharacter($character, $existingCharacter)
    {
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
            $existingItem->bonus_ids = json_encode($item->bonusLists);

            if($key == "neck"){
                $existingCharacter->azerite_level = $item->azeriteItem->azeriteLevel;
            }

            self::updateItemProperties($key, $item, $existingItem->id);

            $existingItem->save();
        }

        $existingCharacter->item_level = $character->items->averageItemLevel;
        $existingCharacter->save();

        return $existingCharacter->id;
    }

    private static function updateItemProperties($itemSlot, $item, $characterGearId)
    {
        // @TODO figure out empty gem slots. Only implementing enchants on rings and wep for now.

        // enchant specific for now

        $enchantList = array('finger1', 'finger2', 'mainHand');
        if(in_array($itemSlot, $enchantList)) {
            // check to see if "enchant" field exists on that item id
            if(!$enchantProp = ItemProperties::where('character_gear_id', $characterGearId)->where('property', 'enchant')->first()) {
                $enchantProp = new ItemProperties();
                $enchantProp->character_gear_id = $characterGearId;
                $enchantProp->property = "enchant";
            }

            $enchantProp->spell_id = isset($item->tooltipParams->enchant) ? $item->tooltipParams->enchant : 0;
            $enchantProp->save();
        }

        // gem stuff goes here
        if(!$socketProp = ItemProperties::where('character_gear_id', $characterGearId)->where('property', 'socket')->first()) {
            $socketProp = new ItemProperties();
            $socketProp->character_gear_id = $characterGearId;
            $socketProp->property = "socket";
        }

        // needs more logic to check if socket exists but isn't filled.
        $socketProp->spell_id = isset($item->tooltipParams->gem0) ? $item->tooltipParams->gem0 : 0;
        $socketProp->save();

        return;
    }
}
