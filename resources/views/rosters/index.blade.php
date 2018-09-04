@extends('layouts.app')

@section('content')
    <h1>All Rosters</h1>
    <a href="rosters/create">
        <button class="float-right btn bg-transparent hover:bg-blue rounded border border-blue text-grey-darkest hover:text-white px-2 py-2">
            New Roster
        </button>
    </a>
    <ul>
        @foreach($rosters as $roster)
            <li>
                <a href="{{ route('rosterShow', $roster->id) }}">{{ $roster->name }}</a>
            </li>
        @endforeach
    </ul>
@endsection
