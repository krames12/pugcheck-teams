@extends('layouts.app')

@section('content')
    <h1>New Roster</h1>

    <form method="POST" action="/rosters/create">
        {{ csrf_field() }}

        <label for="name">Name</label>
        <input type="text" id="name" name="name" />
        <label for="realm">Realm</label>
        <input type="text" id="realm" name="realm"  />
        <label for="faction">Faction</label>
        <select name="faction" id="faction">
            <option value="0">Alliance</option>
            <option value="1">Horde</option>
        </select>
        <button type="submit">Create Roster</button>

    </form>
@endsection