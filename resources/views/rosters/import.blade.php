@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Import Guild</h1>
    <form method="POST" {{ action("RosterController@importGuild", ['id' => $roster->id]) }} class="">
        {{ csrf_field() }}
        <ul class="px-1 import-guild-members-list mb-4">
            @foreach($members as $member)
                <li class="list-reset leading-normal border-b py-1 px-2">
                    <input type="checkbox" value="{{ $member->character->name }}" name="character[]" />
                    <img src="{{ asset('images').'/'.App\Http\Controllers\Lookups::classLookup($member->character->class).'.png' }}"
                         alt="{{ App\Http\Controllers\Lookups::classLookup($member->character->class) }}"
                         class="class-icon-small px-1"
                    >
                    {{ $member->character->name }}
                </li>
            @endforeach
        </ul>
        <button type="submit" class="btn bg-blue hover:bg-blue-darker text-white rounded px-4 py-2">Import Characters</button>
    </form>
@endsection
