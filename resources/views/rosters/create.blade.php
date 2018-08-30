@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-sm">
        <h1>New Roster</h1>
        <form method="POST" action="/rosters/create" class="bg-white shadow-md rounded px-8 py-4">
            {{ csrf_field() }}

            <div class="mb-6">
                <label for="name" class="block text-grey-darker">Name</label>
                <input type="text"
                       id="name" name="name"
                       class="w-full border rounded py-2 px-2"
                       placeholder="Character Name"
                       required
                />
            </div>
            <div class="mb-6">
                <label for="realm" class="block text-grey-darker">Realm</label>
                <input type="text"
                       id="realm" name="realm"
                       class="w-full border rounded py-2 px-2"
                       required
                />
            </div>
            <div class="mb-6">
                <label for="faction" class="block text-grey-darker">Faction</label>
                <select name="faction" id="faction" class="w-full bg-grey-lighter border rounded py-2 px-2">
                    <option value="0">Alliance</option>
                    <option value="1">Horde</option>
                </select>
            </div>
            <button type="submit" class="btn bg-blue text-white ">Create Roster</button>
        </form>
    </div>

    @include('layouts.errors')
@endsection
