@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto max-w-sm">
        <h1>Edit Roster</h1>
        <form method="POST" action="/rosters/{{ $roster->id }}/edit" class="bg-white shadow-md rounded px-8 py-4">
            {{ csrf_field() }}
            {{ method_field("PATCH") }}

            <div class="mb-3">
                <label for="name" class="block text-grey-darker">Name</label>
                <input type="text"
                       id="name" name="name"
                       class="w-full border rounded py-2 px-2"
                       placeholder="Roster Name"
                       value="{{ $roster->name }}"
                       required
                />
            </div>
            <div class="mb-3">
                <label for="guild_name" class="block text-grey-darker">Guild Name <span class="text-grey">(For guild import)</span></label>
                <input type="text"
                       id="guild_name" name="guild_name"
                       class="w-full border rounded py-2 px-2"
                       placeholder="Guild Name"
                       value="{{ $roster->guild_name }}"
                       required
                />
            </div>
            <div class="mb-3">
                <label for="realm" class="block text-grey-darker">Realm</label>
                <select name="realm" id="realm" class="w-full bg-white border rounded py-2 px-2">
                    @foreach($realms as $realm)
                        <option value="{{ $realm->id }}"
                                {{ $roster->realm->id == $realm->id ? 'selected="selected"' : "" }}
                        >
                            {{ $realm->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="faction" class="block text-grey-darker">Faction</label>
                <select name="faction" id="faction" class="w-full bg-white border rounded py-2 px-2">
                    <option value="0" {{ $roster->faction == 0 ? 'selected="selected"' : "" }} >Alliance</option>
                    <option value="1" {{ $roster->faction == 1 ? 'selected="selected"' : "" }} >Horde</option>
                </select>
            </div>
            <button type="submit" class="btn bg-blue text-white ">Update Roster</button>
        </form>
    </div>

    @include('layouts.errors')
@endsection
